<?php
include __DIR__ . '/../config/db_connection.php';

class PatientController {

    // SHOW PATIENT CREATE FORM
    public function index() {
        include __DIR__ . '/../../public/patient_create.php';
    }

    // FOR CREATE PATIENT AJAX REQUEST
    public function patient_create() {
        $return_arr = ['error' => 1, 'msg' => 'Something went wrong.'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            global $conn;
            // COLLECT & SANITINZE DATA
            $first_name = trim($_POST['first_name']);
            $surname = trim($_POST['surname']);
            $dob = trim($_POST['dob']);
            $age = !empty($_POST['age']) ? trim($_POST['age']) : 0;
            $data = json_encode($_POST['data']);
            $total_score = trim($_POST['total_score']);

            $sql = "INSERT INTO patients (first_name, surname, dob, age, data, total_score) VALUES (?, ?, ?, ?, ?, ?)";
            $params = [$first_name, $surname, $dob, $age, $data, $total_score];
            
            $stmt = sqlsrv_query($conn, $sql, $params);
            $return_arr['msg'] = $stmt ? "Patient created successfully." : "Error: " . print_r(sqlsrv_errors(), true);

            // CLOSE CONNECTION
            sqlsrv_close($conn);
            echo json_encode($return_arr);
        }
    }
}
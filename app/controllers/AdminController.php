<?php
include __DIR__ . '/../config/db_connection.php';

class AdminController {

    // FOR SHOW PATIENT LIST IN ADMIN VIEW
    public function index() {
        global $conn;

        $sort = !empty($_GET['sort']) ? $_GET['sort'] : 'id';
        $order = !empty($_GET['order']) ? $_GET['order'] : 'DESC';
        $search = $_GET['search'] ?? '';

        $sql = "SELECT id, first_name, surname, dob, age, total_score, created_at FROM patients ";
        $params = [];
        if(!empty($search)) {
          $sql .= " WHERE first_name LIKE ? OR surname LIKE ? ";
          $params[] = "%$search%";
          $params[] = "%$search%";
        }
        $sql .= " ORDER BY $sort $order";

        $statement = sqlsrv_query($conn, $sql, $params);

        if ($statement === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $patients = [];
        while ($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)) {
            $patients[] = $row;
        }
        sqlsrv_close($conn);
        // Pass data to view
        include __DIR__ . '/../../public/admin/patient_list.php';
    }

    // FOR DELETE PATIENT AJAX REQUEST
    public function patient_delete() {
      $return_arr = ['error' => 1, 'msg' => 'Something went wrong.'];
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         if ($_POST['method'] === 'DELETE') {
            global $conn;
            $id = $_POST['patient_id'];
            $sql = "DELETE FROM patients WHERE id = ?";
            $params = [$id];

            $stmt = sqlsrv_query($conn, $sql, $params);
            $return_arr['msg'] = $stmt ? "Patient deleted successfully." : "Error: " . print_r(sqlsrv_errors(), true);
            sqlsrv_close($conn);
            echo json_encode($return_arr);
         }
      }
    }

    // FOR GET SINGLE PATIENT DATA WITH ID FROM ADMIN VIEW
    public function patient_get() {
      $return_arr = ['error' => 1, 'msg' => 'Something went wrong.'];
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        global $conn;
        $id = $_GET['patient_id'];
        $sql = "SELECT * FROM patients WHERE id = ?";
        $params = [$id];

        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC); // Fetch one row as associative array
        sqlsrv_close($conn);
        if(!empty($row['dob'])) {
          $row['dob'] = $row['dob']->format('m/d/Y');
        }
        if(!empty($row['data'])) {
          $row['data'] = json_decode($row['data']);
        }
        echo json_encode($row);
      }
    }

    // FOR UPDATE PATIENT FROM ADMIN VIEW
    public function patient_update() {
      $return_arr = ['error' => 1, 'msg' => 'Something went wrong.'];
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        global $conn;
        $id = $_POST['patient_id'];
        // COLLECT & SANITINZE DATA
        $first_name = trim($_POST['first_name']);
        $surname = trim($_POST['surname']);
        $dob = trim($_POST['dob']);
        $age = !empty($_POST['age']) ? trim($_POST['age']) : 0;
        $data = !empty($_POST['data']) ? json_encode($_POST['data']) : [];
        $total_score = !empty($_POST['total_score']) ? trim($_POST['total_score']) : 0;

        $sql = "UPDATE patients SET first_name = ?, surname = ?, dob = ?, age = ?, data = ?, total_score = ? WHERE id = ?";
        $params = [$first_name, $surname, $dob, $age, $data, $total_score, $id];

        $stmt = sqlsrv_query($conn, $sql, $params);
        $return_arr['msg'] = $stmt ? "Patient updated successfully." : "Error: " . print_r(sqlsrv_errors(), true);
        sqlsrv_close($conn);
        echo json_encode($return_arr);
      }
    }
}
// CLOSE CONNECTION
// sqlsrv_close($conn);
<?php
  if(isset($_GET['action'])) {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    if($_GET['action'] == "patient_list") {
      // FOR SHOW PATIENT LIST IN ADMIN VIEW
      $controller->index();
    } else if($_GET['action'] == "patient_delete")  {
      // FOR DELETE PATIENT AJAX REQUEST
      $controller->patient_delete();
    } else if($_GET['action'] == "patient_get")  {
      // FOR GET SINGLE PATIENT DATA WITH ID FROM ADMIN VIEW
      $controller->patient_get();
    } else if($_GET['action'] == "patient_update")  {
      // FOR UPDATE PATIENT FROM ADMIN VIEW
      $controller->patient_update();
    }
  } else { 
    require_once '../app/controllers/PatientController.php';
    $controller = new PatientController();
    if(isset($_GET['user_action']) && $_GET['user_action'] == "patient_create") {
      // FOR CREATE PATIENT AJAX REQUEST
      $controller->patient_create();
    } else {
      // SHOW PATIENT CREATE FORM
      $controller->index();
    }
  }
?>
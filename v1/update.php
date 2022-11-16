<?php

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

//include_once("../config/database.php");
include_once("../classes/student.php");

$db = new Database();

$connection = $db->connect();

$student = new Student($connection);

if($_SERVER['REQUEST_METHOD'] === "PUT"){

  $data = json_decode(file_get_contents("php://input"));
  $url = $_SERVER['REQUEST_URI'];
  $urlArr = explode('/', $url);
  $param = $urlArr[4];

  if(!empty($param)) {
    
    $student->name = $data->name;
    $student->email = $data->email;
    $student->mobile = $data->mobile;

    if($student->name == null){

      $conn = Database::connect();
      $stmt = $conn->prepare("SELECT name FROM students WHERE id = ?");
      $stmt->execute([$param]);
      $result = $stmt->fetch();
      $student->name = $result[0];
      

    } else if($student->email == null) {

      $conn = Database::connect();
      $stmt = $conn->prepare("SELECT email FROM students WHERE id = ?");
      $stmt->execute([$param]);
      $result = $stmt->fetch();
      $student->email = $result[0];

    } else if($student->mobile == null) {

      $conn = Database::connect();
      $stmt = $conn->prepare("SELECT mobile FROM students WHERE id = ?");
      $stmt->execute([$param]);
      $result = $stmt->fetch();
      $student->mobile = $result[0];

    }

    if($student->update_student($param)){

      http_response_code(200);
      echo json_encode([
        "status" => 1,
        "message" => "Student has been updated"
      ]);
    } else {
      http_response_code(500);
      echo json_encode([
        "status" => 0,
        "message" => "Failed to update student"
      ]);
    }
    
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => 0,
      "message" => "id are required"
    ]);
  }
} else {
  http_response_code(503);
    echo json_encode([
      "status" => 0,
      "message" => "Access Denied"
    ]);
}

?>
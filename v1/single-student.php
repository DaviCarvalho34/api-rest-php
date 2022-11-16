<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

//include_once("../config/database.php");
include_once("../classes/student.php");

$db = new Database();

$connection = $db->connect();

$student = new Student($connection);

$url = $_SERVER['REQUEST_URI'];
$urlArr = explode('/', $url);

if($_SERVER['REQUEST_METHOD'] === "GET"){
  $param = $urlArr[4];
  
  if(!empty($param)){
    $student_data = $student->get_single_student($param);

    if(!empty($student_data)) {

      http_response_code(200);
      echo json_encode([
        "status" => 1,
        "data" =>$student_data
      ]);
    } else {
      http_response_code(404);
      echo json_encode([
        "status" => 0,
        "message" => "No users found"
      ]);
    }

  }
} else {

  http_response_code(503);
  echo json_encode([
    "status" => 0,
    "message" => "Access denied"
  ]);
}

?>
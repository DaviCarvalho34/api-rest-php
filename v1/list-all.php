<?php
ini_set("display_errors", 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

//include_once("../config/database.php");
include_once("../classes/student.php");

$db = new Database();

$connection = $db->connect();

$student = new Student($connection);

if($_SERVER['REQUEST_METHOD'] === "GET"){

  $data = $student->get_all_data();

  if(!empty($data)){

    $students["records"] = array();
    foreach($data as $student){
      array_push($students["records"],array(
        "id" => $student['id'],
        "name" => $student['name'],
        "mobile" => $student['mobile'],
        "status" => $student['status'],
        "created_at" => date("Y-m-d",strtotime($student['created_at']))
      ));
    }

    http_response_code(200);
    echo json_encode(array(
      "status" => 1,
      "data" => $students["records"]
    ));
  }

} else {
  http_response_code(503);
  echo json_encode([
    "status" => 0,
    "message" => "Access denied"
  ]);
}

?>
<?php
require 'connect.php';

// CORS headers
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Client-Security-Token, Accept-Encoding");
header("Content-Type: application/json; charset=UTF-8");

// handles preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
   http_response_code(200);
   exit();
}

// handles PUT request
$data = json_decode(file_get_contents("php://input"), true);
$taskID = $data['data']['taskID'];
$title = $data['data']['title'];
$description = $data['data']['description'];
$due_date = $data['data']['due_date'];
$priority = $data['data']['priority'];

// logs the received data for debugging
error_log("Received data: " . print_r($data, true));

$sql = "UPDATE tasks SET title='$title', description='$description', due_date='$due_date', priority='$priority' WHERE taskID='$taskID'";

// logs the SQL query for debugging
error_log("SQL query: " . $sql);

if (mysqli_query($con, $sql)) {
   http_response_code(200);
   echo json_encode(['data' => $data['data'], 'message' => 'Task updated successfully']);
} else {
   http_response_code(500);
   echo json_encode(['message' => 'Failed to update task', 'error' => mysqli_error($con)]);
}

$con->close();

?>
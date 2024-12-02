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

// handles DELETE request
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
   $id = $_GET['id'];

   // logs the received data for debugging
   error_log("Received ID: " . $id);

   $sql = "DELETE FROM tasks WHERE id = '$id'";

   // logs the SQL query for debugging
   error_log("SQL query: " . $sql);

   if (mysqli_query($con, $sql)) {
      http_response_code(200);
      echo json_encode(['message' => 'Task deleted successfully']);
   } else {
      http_response_code(500);
      echo json_encode(['message' => 'Failed to delete task', 'error' => mysqli_error($con)]);
   }

   $con->close();
} else {
   // if the request method is not DELETE, return a 405 Method Not Allowed response
   http_response_code(405);
   echo json_encode(['message' => 'Method Not Allowed']);
}
?>
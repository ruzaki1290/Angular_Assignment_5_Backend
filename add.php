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

   // handles POST request
   $data = json_decode(file_get_contents("php://input"), true);
   $title = $data['data']['title'];
   $description = $data['data']['description'];
   $due_date = $data['data']['due_date'];
   $priority = $data['data']['priority'];

   $sql = "INSERT INTO tasks (title, description, due_date, priority) VALUES ('$title', '$description', '$due_date', '$priority')";

   if (mysqli_query($con, $sql)) {
      http_response_code(201);
      echo json_encode(['message' => 'Task added successfully']);
   } else {
      http_response_code(500);
      echo json_encode(['message' => 'Failed to add task']);
   }

   $stmt->close();
   $con->close();
?>
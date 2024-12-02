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
   $tasks = [];
   $sql = "SELECT id, title, description, due_date, priority FROM tasks";

   if ($result = mysqli_query($con, $sql)) 
   {
      $count = 0;

      while ($row = mysqli_fetch_assoc($result))
      {  
         $tasks[$count]['id'] = $row['id'];
         $tasks[$count]['title'] = $row['title'];
         $tasks[$count]['description'] = $row['description'];
         $tasks[$count]['due_date'] = $row['due_date'];
         $tasks[$count]['priority'] = $row['priority'];
         $count++;
      }

      echo json_encode(['data' => $tasks]);
   }
   else {
      http_response_code(404);
   }
?>
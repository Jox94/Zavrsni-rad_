<?php
include "functions.php";

  global $conn;
  require("connection.php");
    
    $SQL = "SELECT * FROM notification";
    $result = $conn->query($SQL);
    if ($result->num_rows > 0) {
       echo "<ul>";
              while($red = $result->fetch_assoc()) {
                echo "<li> RBR:".$red[id]." | ".$red[user]." ".$red[action]." | ".$red[date];              
              }
        echo "</ul>";
    }


?>

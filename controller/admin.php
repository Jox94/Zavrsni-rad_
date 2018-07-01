<?php
require("connection.php");
// Status flag:
$LoginSuccessful = false;

// Check username and password:
if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
    $Username = $_SERVER['PHP_AUTH_USER'];
    $Password = $_SERVER['PHP_AUTH_PW'];

    $usr = "";
    $pwd ="";
    $creds = $conn->query("SELECT user, password FROM admin");
    if ($creds->num_rows > 0) {
              while($param = $creds->fetch_assoc()) {
                $pwd = $param['password'];
                $usr = $param["user"];
              }
    }

    if ($Username == $usr && md5($Password) == $pwd){
        $LoginSuccessful = true;
    }
}
// Login passed successful?
if (!$LoginSuccessful){
    header('WWW-Authenticate: Basic realm="Admin panel"');
    header('HTTP/1.0 401 Unauthorized');
    echo "<script type='text/javascript'>alert('Nemate ovlašćenja za pristup ovoj stranici! Bićete vraćeni na početnu stranicu.');</script>";
    header( "Refresh:0; url= /");
}
else {
?>
<!DOCTYPE html>
<html lang="rs">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/png" ref="/favicon.ico">
  <title>Admin | Baza zaposlenih</title>
  <link rel="stylesheet" href="../css/baza.css" />
  <link rel="stylesheet" href="../css/baza_mobile.css" />
</head>
<body>
  <?php  include 'edit.php'; ?>
</body>
<script src="../js/functions.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
</html>
  <?php
}
$conn->close();
 ?>

<?php
  include dirname(__FILE__)."\server.php";
  
  // Create connection
  $conn = new mysqli($servername, $username, $password, $database);
  
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $errorLog = mysqli_escape_string($conn, $_POST['errorLog']);
  $errorDate = date('d-m-y h:i:s');

  //header("Location: $errorLog");

  
  $sql = "INSERT INTO error_logs(errorLog, errorDate) VALUES ('$errorLog', '$errorDate')";

  mysqli_query($conn, $sql);
  
  mysqli_close($conn);
    
?>
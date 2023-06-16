<?php
  include dirname(__FILE__)."\server.php";
  
  // Create connection
  $conn = new mysqli($servername, $username, $password, $database);
  
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  //echo "Connected successfully";

  $name = mysqli_escape_string($conn, $_POST['name_ajx']);
  $lastname = mysqli_escape_string($conn, $_POST['lastname_ajx']);
  $email = mysqli_escape_string($conn, $_POST['email_ajx']);
  $password = mysqli_escape_string($conn, $_POST['password_ajx']);
  $phoneNumber = mysqli_escape_string($conn, $_POST['phoneNumber_ajx']);
  $humanid = mysqli_escape_string($conn, $_POST['humanid_ajx']);
  $dateOfBirth = mysqli_escape_string($conn, $_POST['dateOfBirth_ajx']);
  $gender = mysqli_escape_string($conn, $_POST['gender_ajx']);
  $registerDate = date('d-m-y h:i:s');
  
  //Control
  $sql = "SELECT email, phoneNumber, humanid FROM users";
  $result = mysqli_query($conn, $sql);

  $durdur = false;
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      if($row['email'] == $email) {
        //echo "E-mail is already registered. Did you forget your password?";
        echo 'email';
        $durdur = true;
      }
    }
  }
  //Control

  //Kayıt
  if($durdur) {
    return false;
  }
  else {
    $sql = "INSERT INTO users (name, lastname, 
    email, pass, phoneNumber, humanid, dateOfBirth, gender, registerDate)
    VALUES ('". $name ."', '". $lastname ."', '". $email ."', '". $password ."'," .
    " '". $phoneNumber ."', '". $humanid ."', '". $dateOfBirth ."', '". $gender ."', '". $registerDate ."')";

    if (mysqli_query($conn, $sql)) {
      echo "new_record";
    } else {
      //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }
  
  mysqli_close($conn);
    
?>
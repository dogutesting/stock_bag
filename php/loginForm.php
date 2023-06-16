<?php
    include dirname(__FILE__)."\server.php";
    header("Content-Type: text/plain");
  
    $conn = new mysqli($servername, $username, $password, $database);
    $login_date = date('d-m-y H:i:s');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //phone or email connection

    $email = mysqli_escape_string($conn, $_POST['login_email']);
    $password = mysqli_escape_string($conn, $_POST['login_password']);
    
    $sql = "SELECT * FROM users WHERE email = '$email' AND pass = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        session_start();
        $_SESSION['logged_in'] = "1";
        $_SESSION['user_id'] = $row['u_id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_lastname'] = $row['lastname'];
        $user_id = $row['u_id'];
        echo "location:trade.php";
        /* $sql2 = "INSERT INTO users_login_history (log_user_id, login_date) VALUES ('$user_id', '$login_date')";
        if ($conn->query($sql2) === TRUE) {
            echo "location:trade.php";
        } */
    }
    else {
        echo "notFound";
    }

    mysqli_close($conn);
?>
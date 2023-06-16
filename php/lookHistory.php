<?php
    include dirname(__FILE__)."\server.php";
    header("Content-Type: text/plain");
    session_start();

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (!isset($_SESSION)) {
        session_start();
    }
    if(!isset($_SESSION["user_id"])) {
        mysqli_close($conn);
        header("Location: ../login.php");
        exit;
    }
    $look_user_id = $_SESSION['user_id'];
    $look_stock = mysqli_escape_string($conn, $_POST['lookedStock']);
    $look_price = mysqli_escape_string($conn, $_POST['lookedPrice']);
    $look_price .= " EUR";
    $look_date = date('d.m.y H:i:s');

    $sql = "INSERT INTO looks_history (look_user_id, look_stock, look_price, look_date)". 
    "VALUES ('$look_user_id', '$look_stock', '$look_price', '$look_date')";
    if (mysqli_query($conn, $sql)) {
        //echo "Başarılı";
        echo "Nice";
    } else {
      //echo "Hata" . mysqli_error($conn);
      //die();
    }

    mysqli_close($conn);
?>
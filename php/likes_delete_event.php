<?php 
    include dirname(__FILE__)."\server.php";

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
    $usr_id = $_SESSION['user_id'];
    $row_id = $_POST['like_row_id'];

    $sql = "DELETE FROM likes_list WHERE who_liked='$usr_id' AND likes_id='$row_id'";

    if ($conn->query($sql) === TRUE) {
    echo "l_r_s";
    } else {
    //echo "Error deleting record: " . $conn->error;
    //echo "error";
    }

    mysqli_close($conn);
?>
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
    $liked_user_id = $_SESSION['user_id'];

    $liked_stock = mysqli_escape_string($conn, $_POST['likedStock']);
    $liked_stock_price = mysqli_escape_string($conn, $_POST['likedPrice']);
    $liked_date = date('d.m.y');

    $sql = "INSERT INTO likes_list (who_liked, liked_name, liked_price, liked_date)".
    "VALUES ('$liked_user_id', '$liked_stock', '$liked_stock_price', '$liked_date')";
    if (mysqli_query($conn, $sql)) {
        $last_id = mysqli_insert_id($conn);
        //echo "Nice:" . $last_id;
        echo "<tr data-like-id=".$last_id."><td>". $liked_stock . "</td>\n".
        "<td title='Dies war der Preis an dem Tag, an dem es gemocht wurde.'>". $liked_stock_price . "</td>\n".
        "<td>". $liked_date ."</td>
        <td><button type='button' class='removeLike'><i class='fa-solid fa-heart-crack'></i></button></td>".
        "</tr>";

    } else {
      //echo "Hata" . mysqli_error($conn);
      //die();
    }

    mysqli_close($conn);
?>
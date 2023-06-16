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
    $sql = "SELECT * FROM likes_list WHERE who_liked='$usr_id' ORDER BY likes_id DESC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo "<tr data-like-id=".$row['likes_id']."><td>". $row['liked_name'] . "</td>\n".
        "<td title='Dies war der Preis an dem Tag, an dem es gemocht wurde.'>". $row['liked_price'] . "</td>\n".
        "<td>". $row['liked_date'] ."</td>
        <td><button type='button' class='removeLike'><i class='fa-solid fa-heart-crack'></i></button></td>".
        "</tr>";
        /*
        <td><button type='button' class='removeLike'>Löschen Like</button></td>". 
        "<td>" . explode(' ', $row['liked_date'])[0] ."</td>\n"."</tr>"; 
        */
    }
    } else {
      //echo "<div style='text-align: center; color: red;'>Es ist so verlassen hier. Versuchen Sie, ein paar Anrufe zu tätigen.</div>";
    }

    mysqli_close($conn);

?>
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
    
    $sql = "SELECT * FROM looks_history WHERE look_user_id='$usr_id' ORDER BY look_id DESC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo "<tr><td>". $row['look_stock'] . "</td>\n".
        "<td>". $row['look_price'] . "</td>\n".
        "<td>" . explode(' ', $row['look_date'])[1] ."</td>\n".
        "<td>" . explode(' ', $row['look_date'])[0] ."</td>\n"."</tr>";
    }
    } else {
      //echo "<div style='text-align: center; color: red;'>Es ist so verlassen hier. Versuchen Sie, ein paar Anrufe zu tätigen.</div>";
    }

    mysqli_close($conn);

?>
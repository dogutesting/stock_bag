<?php
    include dirname(__FILE__)."\server.php";
    header("Content-Type: text/plain");

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //echo $req_stock . " " . $quantity;
    $req_stock = mysqli_escape_string($conn, $_POST['stocks']);
    $quantity = mysqli_escape_string($conn, $_POST['quantity']);
    //$anteil_price = mysqli_escape_string($conn, $_POST['anteil_price']);

    $sch = mysqli_escape_string($conn, $_POST['sch']);

    $anteil_price = number_format((float)str_replace(",", ".", explode(" ", $sch)[0]) / (float)$quantity, 2, ',', '.'); 

    if (!isset($_SESSION)) {
        session_start();
    }
    $who_want = $_SESSION['user_id'];
    $status = "envanter";
    $request_date = date('d-m-y H:i:s');
    $add_symbol = mysqli_escape_string($conn, $_POST['add_symbol']);

    $sql = "INSERT INTO stock_requests (stock_name, request_quantity, anteil_price, sch, who_want, stat, request_date, symbol)". 
    "VALUES ('$req_stock', '$quantity', '$anteil_price EUR', '$sch', '$who_want', '$status', '$request_date', '$add_symbol')";
    if (mysqli_query($conn, $sql)) {
        //header('location:..\transactions.php');
        echo    "<tr data-id='". mysqli_insert_id($conn) ."'>
            <td>". $req_stock ."</td>
            <td>". $quantity ."</td>
            <td>". number_format((float)str_replace(",", ".", explode(" ", $anteil_price)[0]), 2, ',', '.') ." EUR</td>
            <td>". number_format((float)str_replace(",", ".", explode(" ", $sch)[0]), 2, ',', '.') ." EUR</td>
            <td>". $status ."</td>
            <td>". $request_date ."</td>
            <td><button type='button' class='cancelRequest'>Cancel Request</button></td>
        </tr>";
    } else {
      //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      //echo "Error";
    }

    mysqli_close($conn);

?>
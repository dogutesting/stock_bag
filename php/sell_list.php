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

$sql = "SELECT * FROM sell_requests WHERE sell_want='$usr_id' ORDER BY sell_id DESC";
$result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $satilanFiyat = (float)$row["sell_price"] * (float)$row["sell_quan"];
            $alinanFiyat =  (float)str_replace(",", ".", $row["anteil_price"]) * (float)$row["sell_quan"];   
            
            $karZarar = number_format($satilanFiyat - $alinanFiyat, 2, ",", ".");
            $karZararTD = "";
            $karZararYuzde = number_format((($satilanFiyat - $alinanFiyat) / $alinanFiyat)  * 100, 2, ',', '.');
            
            $gosterilecekText = "";
            
            $floatKarZarar = (float)$karZarar;
            if($floatKarZarar < 0) {
                $karZararTD = "neg";
                $gosterilecekText = $karZarar."€ / ".$karZararYuzde."%";
            } else if($floatKarZarar > 0) {
                $karZararTD = "poz";
                $gosterilecekText = "+".$karZarar."€ / +".$karZararYuzde."%";
            } else {
                $karZararTD = "";
                $gosterilecekText = $karZarar."€ / ".$karZararYuzde."%";
            } 

            echo "<tr>".
                    "<td>". $row['sell_name'] . "</td>\n".
                    "<td>" . $row['sell_quan'] ."</td>\n".
                    "<td>" . number_format($row['sell_price'], 2, ',', '.') ." EUR</td>\n".
                    "<td>" . number_format((float)$row["sell_quan"] * (float)$row["sell_price"], 2, ',', '.') ." EUR</td>\n".
                    "<td>" . $row["anteil_price"] ." EUR</td>\n".
                    "<td class='$karZararTD'>" . $gosterilecekText . "</td>\n".
                    "<td>". $row["sell_date"] ."</td>\n"
                ."</tr>";
        }
    }

    mysqli_close($conn);
    

?>
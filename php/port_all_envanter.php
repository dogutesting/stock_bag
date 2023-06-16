<?php
    include dirname(__FILE__)."\server.php";
    require dirname(__FILE__). "\\..\\vendor\\autoload.php";

    use Scheb\YahooFinanceApi\ApiClient;
    use Scheb\YahooFinanceApi\ApiClientFactory;
    use GuzzleHttp\Client;
/* 
    // Create a new client from the factory
    $client = ApiClientFactory::createApiClient(); */

    // Or use your own Guzzle client and pass it in
    $options = [/* ... */];
    $guzzleClient = new Client($options);
    $client = ApiClientFactory::createApiClient($guzzleClient);

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

    $sql = "SELECT * FROM stock_requests WHERE who_want='$usr_id' AND stat='envanter' ORDER BY id DESC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {

        $stockSymbol = $row["symbol"];

        $quote = $client->getQuote($stockSymbol); 
        
        $crn = " EUR";
        $currencyName = $quote->getCurrency();
        $exchangeRate = $client->getExchangeRate($currencyName, "EUR");
        $rate = $exchangeRate->getAsk();

        //şuanki parça fiyatı -> şuanki parça fiyatı
        $suankiParcaFiyati = $rate * $quote->getRegularMarketPrice();
        $suankiParcaFiyati = (float)number_format($suankiParcaFiyati, 2); // işlem yapılabilir

        //eldeki fiyat  ->  parça miktarı * şuanki parça fiyatı
        $eldekiFiyat =  (float)$row["quantity"] * $suankiParcaFiyati; //işlem yapılabilir

        $toplamOdenen = (float)str_replace(",", ".", explode(" ", $row["sch"])[0]); //işlem yapılabilir

        //echo "<b>". gettype($toplamOdenen) . ":" . $toplamOdenen ."</b><br>";

        $karZarar = $eldekiFiyat - $toplamOdenen;
        
        $toplamKar = 0;
        $toplamZarar = 0;
        $karZararTD = "";

        if($karZarar < 0) {
            $karZararTD = "neg";
            $toplamKar.=$karZarar;
        } else if($karZarar > 0) {
            $karZararTD = "poz";
            $toplamZarar.=$karZarar;
        } else {
            $karZararTD = "notr";
        }

        //kar/zarar oranı
        $karZararYuzde = number_format(($eldekiFiyat - $toplamOdenen) / $toplamOdenen  * 100, 2, ',', '.');
        $karZararYuzde.= "%"; 

        //(Yeni fiyat - Eski fiyat) / Eski fiyat * 100 = Yüzde değişim

        echo "<tr data-id='". $row['id'] ."'><td class=\"stockname\">". $row['stock_name'] . "</td>\n".
                        "<td>" . $row['quantity'] ."</td>\n".
                        "<td>" . number_format((float)str_replace(",", ".", explode(" ", $row['anteil_price'])[0]), 2, ',', '.') ." EUR</td>\n".
                        "<td>" . number_format((float)str_replace(",", ".", explode(" ", $row["sch"])[0]), 2, ',', '.') ." EUR</td>\n".
                        "<td>" . number_format($suankiParcaFiyati, 2, ',', '.')  ." EUR</td>\n".
                        "<td class='". $karZararTD ."'>" . number_format($karZarar, 2, ',', '.') . " EUR / " . $karZararYuzde ."</td>\n".
                        "<td><b>" . number_format($eldekiFiyat, 2, ',', '.') ." EUR</b></td>\n".
                        "<td>" . "<button type='button' class='sellStockButton'>verkaufen</button>" ."</td>\n"
                 ."</tr>";
    }
    } else {
      echo "<div style='text-align:center; font-size: 1.5rem; color:red; font-weight: bold'>Ihr Lagerbestand ist leer. Sie können auf der Homepage kaufen.</div>";
    }

    mysqli_close($conn);

?>
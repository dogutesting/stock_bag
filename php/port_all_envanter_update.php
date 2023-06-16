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
    
    $red = false;
    $tbody = "";
    $butunToplamOdenen = 0;
    $toplamEldekiFiyat = 0;
    $toplamKarZarar = 0;
    $toplamHisseSayisi = 0;

    if ($result->num_rows > 0) {
      $toplamHisseSayisi =  $result->num_rows;
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
        $eldekiFiyat =  (float)$row["request_quantity"] * $suankiParcaFiyati; //işlem yapılabilir
        $toplamEldekiFiyat += $eldekiFiyat; //! BÜTÜN TOPLAM ELDEKİ PARA
        
        //$toplamOdenen = (float)str_replace(",", ".", explode(" ", $row["sch"])[0]); //işlem yapılabilir
        $toplamOdenen = (float)$row["request_quantity"] * (float)str_replace(",", ".", explode(" ", $row["anteil_price"])[0]);
        $butunToplamOdenen += $toplamOdenen; //! BÜTÜN TOPLAM ÖDENEN

        //echo "<b>". gettype($toplamOdenen) . ":" . $toplamOdenen ."</b><br>";

        $karZarar = $eldekiFiyat - $toplamOdenen;

        $toplamKarZarar += $karZarar; //! BÜTÜN TOPLAM KÂR
        $karZararTD = "";

        if($karZarar < 0) {
            $karZararTD = "neg";
            //$toplamKar+=$karZarar;
        } else if($karZarar > 0) {
            $karZararTD = "poz";
            //$toplamZarar+=$karZarar;
        } else {
            //$karZararTD = "notr";
        }

        //kar/zarar oranı
        //yeni fiyat - eskifiyat / eskifiyat * 100
        $karZararYuzde = number_format(($eldekiFiyat - $toplamOdenen) / $toplamOdenen  * 100, 2, ',', '.');
        $karZararYuzde.= "%"; 

        //(Yeni fiyat - Eski fiyat) / Eski fiyat * 100 = Yüzde değişim

        $tbody .=  "<tr data-id='". $row['id'] ."'><td class=\"stockname\" data-symbol='". $row["symbol"] ."'>". $row['stock_name'] . "</td>\n".
                        "<td>" . $row['request_quantity'] ."</td>\n".
                        "<td>" . number_format((float)str_replace(",", ".", explode(" ", $row['anteil_price'])[0]), 2, ',', '.') ." EUR</td>\n".
                        //"<td>" . number_format((float)str_replace(",", ".", explode(" ", $row["sch"])[0]), 2, ',', '.') ." EUR</td>\n".
                        "<td>" . str_replace(".", ",", $toplamOdenen) . " EUR</td>\n".
                        "<td>" . number_format($suankiParcaFiyati, 2, ',', '.')  ." EUR</td>\n".
                        "<td class='". $karZararTD ."'>" . number_format($karZarar, 2, ',', '.') . " EUR / " . $karZararYuzde ."</td>\n".
                        "<td><b>" . number_format($eldekiFiyat, 2, ',', '.') ." EUR</b></td>\n".
                        "<td>". str_replace('-', '.', $row["request_date"]) ."</td>\n".
                        "<td>" . "<button type='button' class='sellStockButton'>verkaufen</button>" ."</td>\n"
                 ."</tr>";
    }
    } else {
      echo "<div style='text-align:center; font-size: 1.5rem; color:red; font-weight: bold'>Ihr Lagerbestand ist leer. Sie können auf der Homepage kaufen.</div>";
      $red = true;
    }
    /* $butunToplamOdenen = 0;
    $toplamEldekiFiyat = 0;
    $toplamKar = 0;
    $toplamZarar = 0; */
    //<p style="color: #fa2419; text-shadow: 0px 0px 4px #000000;">
    if(!$red) {
        $toplamYuzdeOrani = number_format(($toplamEldekiFiyat - $butunToplamOdenen) / $butunToplamOdenen * 100, 2, ',', '.');
        $toplamYuzdeOrani .= "%";

        $toplamKarZararClass = "";
        if($toplamKarZarar > 0) {
            $toplamKarZararClass = 'color: lightgreen; text-shadow: 0px 0px 4px #0000009a;';
        } else if($toplamKarZarar < 0) {
            $toplamKarZararClass = 'color: #fa2419; text-shadow: 0px 0px 4px #0000009a;';
        }
        else {
            $toplamKarZararClass = 'color: white; text-shadow: 0px 0px 4px #0000009a;';
        }
        echo '<div id="squares">
                    <div class="square">
                        <h3><i class="fa-solid fa-list-ul"></i> Gesamtzahl der Transaktionen</h3>
                        <p>
                            '. $toplamHisseSayisi .'
                        </p>
                    </div>

                    <div class="square">
                        <h3><i class="fa-solid fa-money-bill"></i> Gesamtbetrag bezahlt</h3>
                        <p>
                            '. number_format($butunToplamOdenen, 2, ',', '.') . '€' .'
                        </p>
                    </div>

                    <div class="square">
                        <h3><i class="fa-solid fa-money-bill-trend-up"></i> Gesamtgewinn und -verlust</h3>
                        <p style="'. $toplamKarZararClass .'">
                            '. number_format($toplamKarZarar, 2, ',', '.')  . '€ / '. $toplamYuzdeOrani .'
                        </p>
                    </div>
                    
                    <div class="square">
                        <h3><i class="fa-solid fa-euro-sign"></i> Gesamtes Geld in der Hand</h3>
                        <p>
                            '. number_format($toplamEldekiFiyat, 2, ',', '.') . '€' .'
                        </p>
                    </div>

                
            </div>

            <div class="inventarList">
                <table>
                    <thead>
                        <tr>
                            <th>Namen teilen</th>
                            <th>Anteil</th>
                            <th title="Anteil preis zum Zeitpunkt des Kaufs">Anteil Preis</th>
                            <th>Gesamtzahlung</th>
                            <th title="Anteil preis zum aktueller">Aktueller Anteil Preis</th>
                            <th>Gewinn/Verlust</th>
                            <th>Preis zur Hand</th>
                            <th>Kaufdatum</th>
                            <th>Verkauf</th>
                        </tr>
                    </thead>
                    <tbody>'.
                       $tbody
                    .'</tbody>
                </table>
            </div>';
    }
    mysqli_close($conn);

?>
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
    
    //! alttakini kullanma gereği duymadım
    /* function refreshAndExit($conn) {
        echo "refresh";
        mysqli_close($conn);
        exit();
    } */
    function errorAndExit($conn, $err) {
        echo 2;
        $sql_error = "INSERT INTO error_logs (errorLog, errorDate) VALUES $err, date('d.m.y')";
        $conn->query($sql_error);

        mysqli_close($conn);
        exit;
    }
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $dataRefreshId = mysqli_escape_string($conn, $_POST['dataRefreshId']);
    $inputRange = mysqli_escape_string($conn, $_POST['inputRange']);

    if($inputRange <= 0) {
        errorAndExit($conn, "inputRange<=0-divide_stock.php");
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

    $sql = "SELECT * FROM stock_requests WHERE who_want='$usr_id' AND stat='envanter' AND id='$dataRefreshId'";
    $result = $conn->query($sql);

   if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        //$anteil_price = (float)str_replace(",", ".", explode(" ", );
        $anteil_price = explode(" ", $row["anteil_price"])[0];
        
        $id = $row["id"];
        $quantity = $row["request_quantity"];
        $stockSymbol = $row["symbol"];

        if($inputRange > $quantity && $quantity - $inputRange < 0) {
            errorAndExit($conn, "divide_stock.php hata yakalandı.");
        }

        $quote = $client->getQuote($stockSymbol); 
        
        $crn = " EUR";
        $currencyName = $quote->getCurrency();
        $exchangeRate = $client->getExchangeRate($currencyName, "EUR");
        $rate = $exchangeRate->getAsk();
        $suankiParcaFiyati = $rate * $quote->getRegularMarketPrice();
        $suankiParcaFiyati = (float)number_format($suankiParcaFiyati, 2); // işlem yapılabilir 182.28

        $kalan = $quantity - $inputRange;
        // x = $120 - 20;
    
        $sql_kalan_0 = "SELECT * FROM sell_requests WHERE sell_want = '$usr_id' AND sell_symbol='$stockSymbol' AND sell_price='$suankiParcaFiyati'";
        $result_kalan = $conn->query($sql_kalan_0);
        //! üzerine ekle - UPDATE
        if($result_kalan->num_rows > 0) {
            
            while($row_kalan = $result_kalan->fetch_assoc()) {
                $yeni_sell_quan = (int)$row_kalan["sell_quan"] + (int)$inputRange;
                $sell_id = $row_kalan["sell_id"];
                
                $update0 = "";
                $update1 = "";

                if($kalan == 0) {
                    /* $sell_update_stock_update = 
                    "UPDATE sell_requests SET sell_quan = '$yeni_sell_quan' WHERE id='$sell_id' sell_want='$usr_id';
                        UPDATE stock_requests SET stat='space' AND quantity='0' WHERE who_want='$usr_id' AND id='$id'"; */
                        $update0 = "UPDATE sell_requests SET sell_quan = '$yeni_sell_quan', anteil_price='$anteil_price' WHERE sell_id='$sell_id' AND sell_want='$usr_id' ";
                        $update1 = "UPDATE stock_requests SET stat='space', request_quantity='0' WHERE who_want='$usr_id' AND id='$id'";
                }
                if($kalan > 0) {
                    /* $sell_update_stock_update = 
                    "UPDATE sell_requests SET sell_quan = '$yeni_sell_quan' WHERE id='$sell_id' sell_want='$usr_id';
                        UPDATE stock_requests SET quantity='$kalan' WHERE who_want='$usr_id' AND id='$id'"; */
                        $update0 = "UPDATE sell_requests SET sell_quan = '$yeni_sell_quan', anteil_price='$anteil_price' WHERE sell_id='$sell_id' AND sell_want='$usr_id' ";
                        $update1 = "UPDATE stock_requests SET request_quantity='$kalan' WHERE who_want='$usr_id' AND id='$id'";
                }
                
                if($conn->query($update0) && $conn->query($update1)) {
                    echo 1;
                }
                else {
                    errorAndExit($conn, mysqli_error($conn));
                }

                //! üstteki hata verirse alttakini kullan
                /* if($conn->query($update0)){
                    if($conn->query($update1)) {
                        echo "refresh";
                    }
                    else {
                        errorAndExit($conn, "10: " . mysqli_error($conn));
                    }
                }
                else {
                    errorAndExit($conn, "1: " . mysqli_error($conn));
                } */
                
            }
        }
        else {
            //! INSERT INTO > sell_requests
            $sell_name = $row["stock_name"];
            //$sell_quan = $inputRange; //! bölmeyi doğru yapmıyor
            $sell_price = $suankiParcaFiyati;
            $sell_want = $usr_id;
            $sell_symbol = $row["symbol"];
            $sell_date = date("d.m.y H:i:m");
            
            $sql_insert_update0 = "";
            $sql_insert_update1 = "";
            
            if($kalan == 0) {
                /* $sql_insert = "INSERT INTO sell_requests (sell_name, sell_quan, sell_price, sell_want, sell_symbol, sell_date)
                VALUES ('$sell_name', '$sell_quan', '$sell_price', '$sell_want', '$sell_symbol', '$sell_date');
                    UPDATE stock_requests SET stat='space' AND quantity='0' WHERE who_want='$usr_id' AND id='$id'"; */
                $sql_insert_update0 = "INSERT INTO sell_requests (sell_name, sell_quan, sell_price, sell_want, sell_symbol, sell_date, anteil_price)
                VALUES ('$sell_name', '$inputRange', '$sell_price', '$sell_want', '$sell_symbol', '$sell_date', '$anteil_price')";
                $sql_insert_update1 = "UPDATE stock_requests SET stat='space', request_quantity='0' WHERE who_want='$usr_id' AND id='$id'";

            }
            if($kalan > 0) {
                /* $sql_insert = "INSERT INTO sell_requests (sell_name, sell_quan, sell_price, sell_want, sell_symbol, sell_date)
                VALUES ('$sell_name', '$sell_quan', '$sell_price', '$sell_want', '$sell_symbol', '$sell_date');
                    UPDATE stock_requests SET quantity = $kalan  WHERE who_want='$usr_id' AND id='$id'"; */
                $sql_insert_update0 = "INSERT INTO sell_requests (sell_name, sell_quan, sell_price, sell_want, sell_symbol, sell_date, anteil_price)
                VALUES ('$sell_name', '$inputRange', '$sell_price', '$sell_want', '$sell_symbol', '$sell_date', '$anteil_price')";
                $sql_insert_update1 = "UPDATE stock_requests SET request_quantity = $kalan  WHERE who_want='$usr_id' AND id='$id'";
            }
            
            //! hata verirse iç içe yaz
            if($conn->query($sql_insert_update0) && $conn->query($sql_insert_update1)){
                echo 1;
            }
            else {
                errorAndExit($conn, mysqli_error($conn));
            }

        }             
        

    }
   } //else {} sıkıntı oldu

    mysqli_close($conn);

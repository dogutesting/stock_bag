<?php

    require dirname(__FILE__). "\\..\\vendor\\autoload.php";
    
    /* session_start();
    if(!isset($_SESSION['logged_in']) && !isset($_SESSION['logged_in']) == "1") {
        header("Location: login.php");
        exit();
    }  */

    $miniInfo =  $_POST['miniInfo'];

    use Scheb\YahooFinanceApi\ApiClient;
    use Scheb\YahooFinanceApi\ApiClientFactory;
    use GuzzleHttp\Client;

    // Create a new client from the factory
    $client = ApiClientFactory::createApiClient();

    // Or use your own Guzzle client and pass it in
    $options = [/* ... */];
    $guzzleClient = new Client($options);
    $client = ApiClientFactory::createApiClient($guzzleClient);
    
    // Returns Scheb\YahooFinanceApi\Results\Quote
    //$quote = $client->getQuote($miniInfo); 
    $quote = $client->getQuote($miniInfo); 
   
    $shortName = $quote->getShortName();
    $longName = $quote->getLongName();
    $rmPrice = $quote->getRegularMarketPrice();
    $rmDayHigh = $quote->getRegularMarketDayHigh();
    $rmDayLow = $quote->getRegularMarketDayLow();

    $currency000 = $quote->getCurrency();
                                
    //$exchangeRate = $client->getExchangeRate("EUR", $currency000);
    $exchangeRate = $client->getExchangeRate($currency000, "EUR");
    $rate = $exchangeRate->getAsk();

    if(empty($longName)) {
        echo $shortName . "{-}" . number_format($rmPrice * $rate, 2, ',', '.') . "{-}" . number_format($rmDayHigh * $rate, 2, ',', '.') . "{-}" .  number_format($rmDayLow * $rate, 2, ',', '.');
        /* echo $shortName . "{-}" .                                           //0
            number_format($rate * $quote->getAsk(), 2, ',', '.') . "{-}" .  //1
            number_format($rate * $quote->getAsk(), 2, ',', '.') . "{-}" .  //2
            $quote->getSymbol() . "{-}" .                                   //3
            number_format($rmPrice * $rate, 2, ',', '.') . "{-}" .          //4
            number_format($rmDayHigh * $rate, 2, ',', '.') . "{-}" .        //5
            number_format($rmDayLow * $rate, 2, ',', '.');                  //6 */
    }
    else {
        echo $longName . "{-}" . number_format($rmPrice * $rate, 2, ',', '.') . "{-}" . number_format($rmDayHigh * $rate, 2, ',', '.') . "{-}" .  number_format($rmDayLow * $rate, 2, ',', '.');
        /* echo $longName . "{-}" .                                           //0
            number_format($rate * $quote->getAsk(), 2, ',', '.') . "{-}" . //1
            number_format($rate * $quote->getAsk(), 2, ',', '.') . "{-}" . //2
            $quote->getSymbol() . "{-}" .                                  //3
            number_format($rmPrice * $rate, 2, ',', '.') . "{-}" .         //4
            number_format($rmDayHigh * $rate, 2, ',', '.') . "{-}" .       //5
            number_format($rmDayLow * $rate, 2, ',', '.');                 //6 */
    }

    
?>
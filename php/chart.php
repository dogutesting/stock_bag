<?php
require dirname(__FILE__). "\\..\\vendor\\autoload.php";
        
$searchType = $_POST['searchType'];
$searchSymbol =  $_POST['searchSymbol'];

use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;
use GuzzleHttp\Client;

$client = ApiClientFactory::createApiClient();

$options = [/* ... */];
$guzzleClient = new Client($options);
$client = ApiClientFactory::createApiClient($guzzleClient);

$historicalData = $client->getHistoricalQuoteData(
    //"AAPL",
    $searchSymbol,
    ApiClient::INTERVAL_1_DAY,
    new \DateTime((string)$searchType),
    //new \DateTime("-5 years"),
    new \DateTime("today")
);

$quote = $client->getQuote($searchSymbol); 
$currency000 = $quote->getCurrency();
$exchangeRate = $client->getExchangeRate($currency000, "EUR");
$rate = $exchangeRate->getAsk();

$ct = count($historicalData);
$array_string = "";

for($i=0; $i<$ct; $i++) {
    $gd = $historicalData[$i]->getDate()->format('d/m/Y');
    //$gd = substr($gd, 0, -5);
    $cp = $rate * $historicalData[$i]->getClose();

    $array_string .= $gd . "-|-" . $cp . "|||";
}
$array_string = substr($array_string, 0, -3);
echo $array_string;





?>
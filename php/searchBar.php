<?php
    //require dirname(__FILE__)."\\vendor\\autoload.php";

    require dirname(__FILE__). "\\..\\vendor\\autoload.php";
    
    $srcTxt =  $_POST['srcTxt'];

    use Scheb\YahooFinanceApi\ApiClient;
    use Scheb\YahooFinanceApi\ApiClientFactory;
    use GuzzleHttp\Client;

    // Create a new client from the factory
    $client = ApiClientFactory::createApiClient();

    // Or use your own Guzzle client and pass it in
    $options = [/* ... */];
    $guzzleClient = new Client($options);
    $client = ApiClientFactory::createApiClient($guzzleClient);

    // Returns an array of Scheb\YahooFinanceApi\Results\SearchResult
    $searchResult = $client->search($srcTxt);
    //$searchResult = $client->search("Apple");
    $arrLength = count($searchResult);

    $searchRslt = "";
    for($i=0; $i<$arrLength; $i++) {
        //$searchRslt .= $searchResult[$i]->getSymbol() . " - " . $searchResult[$i]->getName() . "<|>";
        $searchRslt .= $searchResult[$i]->getName() . " - " . $searchResult[$i]->getSymbol() . "<|>";
        /* if($i == 4) {
            break;
        } */
    }
    echo $searchRslt;
?>
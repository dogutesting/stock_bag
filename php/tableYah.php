<?php

    require dirname(__FILE__). "\\..\\vendor\\autoload.php";

    /* session_start();
    if(!isset($_SESSION['logged_in']) && !isset($_SESSION['logged_in']) == "1") {
        header("Location: login.php");
        exit();
    }  */

    $slctdStck =  $_POST['selectedStock'];
    
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
    $quote = $client->getQuote($slctdStck); 
    
   
    $preMarketTime = $quote->getPreMarketTime();
    $dividendDate = $quote->getDividendDate();
    $earningsTimestamp = $quote->getEarningsTimestamp();
    $earningsTimestampStart = $quote->getEarningsTimestampStart();
    $earningsTimestampEnd = $quote->getEarningsTimestampEnd();
    $regularMarketTime = $quote->getRegularMarketTime();

    $crn = " EUR";
    $currencyName = $quote->getCurrency();
    $exchangeRate = $client->getExchangeRate($currencyName, "EUR");
    $rate = $exchangeRate->getAsk();

    $timeFormats = array($preMarketTime, $dividendDate, $earningsTimestamp, $earningsTimestampStart, $earningsTimestampEnd, $regularMarketTime);
    
    
    for($i=0; $i<count($timeFormats); $i++) {
        if(is_null($timeFormats[$i])) {
            $timeFormats[$i] = "";
         }
         else {
            $timeFormats[$i] = $timeFormats[$i]->format('d/m/Y');
         }
    }

    echo "<h2 class='stock_name_gh'><i class='fa-solid fa-circle-info'></i> Stock Informationen</h2>" .
     "<hr class='marginpaddingZero hrC' style='margin-top: 5px; margin-bottom: 10px;'>" .
     "<div style='overflow: auto; -webkit-overflow-scrolling: touch; max-height: 650px;'>"
     ."<table class='iTable'>" .
     "<tr><th>" . "Short Name: " . "</th><td>" . $quote->getShortName() . "</td></tr>" .
      "<tr><th>" . "Long Name: " . "</th><td>" . $quote->getLongName() . "</td></tr>" .
      "<tr><th>" . "Symbol: " . "</th><td id='symb'>" . $quote->getSymbol() . "</td></tr>" .
      "<tr><th>" . "Market Cap: " . "</th><td>" . number_format($rate * $quote->getMarketCap(), 2, ',', '.') . $crn ."</td></tr>" .
      "<tr><th>" . "Regular Market Price: " . "</th><td id='rmp'>" . number_format($rate * $quote->getRegularMarketPrice(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Regular Market Day High: " . "</th><td>" . number_format($rate * $quote->getRegularMarketDayHigh(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Regular Market Day Low: " . "</th><td>" . number_format($rate * $quote->getRegularMarketDayLow(), 2, ',', '.') . $crn ."</td></tr>" .
      "<tr><th>" . "Regular Market Open: " . "</th><td>" . number_format($rate * $quote->getRegularMarketOpen(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Regular Market Previous Close: " . "</th><td>" . number_format($rate * $quote->getRegularMarketPreviousClose(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Regular Market Change: " . "</th><td>" . number_format($rate * $quote->getRegularMarketChange(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Regular Market Change Percent: " . "</th><td>%" . number_format($rate * $quote->getRegularMarketChangePercent(), 2, ',', '.') . "</td></tr>" .
      "<tr><th>" . "Regular Market Time: " . "</th><td>" . $timeFormats[5] . "</td></tr>" .
      "<tr><th>" . "Regular Market Volume: " . "</th><td>" . number_format($rate * $quote->getRegularMarketVolume(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Average Daily Volume 10 Day: " . "</th><td>" . number_format($rate * $quote->getAverageDailyVolume10Day(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Average Daily Volume 3 Month: " . "</th><td>" . number_format($rate * $quote->getAverageDailyVolume3Month(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Fifty Day Average Change: " . "</th><td>" . number_format($rate * $quote->getFiftyDayAverageChange(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Fifty Day Average Change Percent: " . "</th><td>%" . number_format($rate * $quote->getFiftyDayAverageChangePercent(), 2, ',', '.') . "</td></tr>" .
      "<tr><th>" . "Fifty Two Week High: " . "</th><td>" . number_format($rate * $quote->getFiftyTwoWeekHigh(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Fifty Two Week High Change: " . "</th><td>" . number_format($rate * $quote->getFiftyTwoWeekHighChange(), 2, ',', '.') . $crn ."</td></tr>" .
      "<tr><th>" . "Fifty Two Week High Change Percent: " . "</th><td>%" . number_format($rate * $quote->getFiftyTwoWeekHighChangePercent(), 2, ',', '.') . "</td></tr>" .
      "<tr><th>" . "Fifty Two Week Low: " . "</th><td>" . number_format($rate * $quote->getFiftyTwoWeekLow(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Fifty Two Week Low Change: " . "</th><td>" . number_format($rate * $quote->getFiftyTwoWeekLowChange(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Fifty Two Week Low Change Percent: " . "</th><td>%" . number_format($rate * $quote->getFiftyTwoWeekLowChangePercent(), 2, ',', '.') . "</td></tr>" .
      "<tr><th>" . "Two Hundred Day Average: " . "</th><td>" . number_format($rate * $quote->getTwoHundredDayAverage(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Two Hundred Day Average Change: " . "</th><td>" . number_format($rate * $quote->getTwoHundredDayAverageChange(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Two Hundred Day Average Change Percent: " . "</th><td>%" . number_format($rate * $quote->getTwoHundredDayAverageChangePercent(), 2, ',', '.') .
      "<tr><th>" . "Market State: " . "</th><td>" . $quote->getMarketState() . "</td></tr>" .
      "<tr><th>" . "Ask: " . "</th><td>" . number_format($rate * $quote->getAsk(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Ask Size: " . "</th><td>" . $quote->getAskSize() . "</td></tr>" .
      "<tr><th>" . "Bid: " . "</th><td>" . number_format($rate * $quote->getBid(), 2, ',', '.'). $crn ."</td></tr>" .
      "<tr><th>" . "Bid Size: " . "</th><td>" . $quote->getBidSize() . "</td></tr>" .
      "<tr><th>" . "Book Value: " . "</th><td>" . number_format($rate * $quote->getBookValue(), 2, ',', '.') . "</td></tr>" .
      "<tr><th>" . "Dividend Date: " . "</th><td>" . $timeFormats[1] . "</td></tr>" .
      "<tr><th>" . "Earnings Timestamp: " . "</th><td>" . $timeFormats[2] . "</td></tr>" .
      "<tr><th>" . "Earnings Timestamp Start: " . "</th><td>" . $timeFormats[3] . "</td></tr>" .
      "<tr><th>" . "Earnings Timestamp End: " . "</th><td>" . $timeFormats[4] . "</td></tr>" .
      "<tr><th>" . "Eps Trailing Twelve Months: " . "</th><td>" . number_format($quote->getEpsTrailingTwelveMonths(), 2, ',', '.') . "</td></tr>" .
      "<tr><th>" . "Exchange: " . "</th><td>" . $quote->getExchange() . "</td></tr>" .
      "<tr><th>" . "Exchange Data Delayed By: " . "</th><td>" . $quote->getExchangeDataDelayedBy() . "</td></tr>" .
      "<tr><th>" . "Exchange Timezone Name: " . "</th><td>" . $quote->getExchangeTimezoneName() . "</td></tr>" .
      "<tr><th>" . "Exchange Timezone Short Name: " . "</th><td>" . $quote->getExchangeTimezoneShortName() . "</td></tr>" .
      "<tr><th>" . "Financial Currency: " . "</th><td>" . $quote->getFinancialCurrency() . "</td></tr>" .
      "<tr><th>" . "Forward PE: " . "</th><td>" . number_format($rate * $quote->getForwardPE(), 2, ',', '.') . "</td></tr>" .
      "<tr><th>" . "Price Hint: " . "</th><td>" . $quote->getPriceHint() . "</td></tr>" .
      "<tr><th>" . "Price To Book: " . "</th><td>" . number_format($rate * $quote->getPriceToBook(), 2, ',', '.') . "</td></tr>" .
      "<tr><th>" . "Quote Source Name: " . "</th><td>" . $quote->getQuoteSourceName() . "</td></tr>" .
      "<tr><th>" . "Quote Type: " . "</th><td>" . $quote->getQuoteType() . "</td></tr>" .
      "<tr><th>" . "Shares Outstanding: " . "</th><td>" . number_format($rate * $quote->getSharesOutstanding(), 2, ',', '.') . $crn ."</td></tr>" .
      "<tr><th>" . "Source Interval: " . "</th><td>" . $quote->getSourceInterval() . "</td></tr>" .
      "<tr><th>" . "Trailing Annual Dividend Rate: " . "</th><td>" . number_format($rate * $quote->getTrailingAnnualDividendRate(), 2, ',', '.') . "</td></tr>" .
      "<tr><th>" . "Trailing Annual Dividend Yield: " . "</th><td>" . number_format($rate * $quote->getTrailingAnnualDividendYield(), 2, ',', '.') . "</td></tr>" .
      "<tr><th>" . "Trailing PE: " . "</th><td>" . number_format($rate * $quote->getTrailingPE(), 2, ',', '.') . "</td></tr>" .
      "<tr><th>" . "Pre Market Change: " . "</th><td>" . number_format($rate * $quote->getPreMarketChange(), 2, ',', '.') . $crn ."</td></tr>" .
      "<tr><th>" . "Pre Market Change Percent: " . "</th><td>%" . number_format($rate * $quote->getPreMarketChangePercent(), 2, ',', '.') . "</td></tr>" .
      "<tr><th>" . "Pre Market Price: " . "</th><td>" . number_format($rate * $quote->getPreMarketPrice(), 2, ',', '.') . $crn ."</td></tr>" .
      "<tr><th>" . "Pre Market Time: " . "</th><td>" . $timeFormats[0] . "</td></tr>" .
     "</td></tr></table>".
     "</div>";
?>
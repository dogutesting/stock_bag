<!DOCTYPE html>

<?php
    error_reporting(0);
    session_start();
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == "1") {

    } 
    else {
        header("Location: login.php");
        exit();
    }
    require dirname(__FILE__). "\\vendor\\autoload.php";
    use Scheb\YahooFinanceApi\ApiClient;
    use Scheb\YahooFinanceApi\ApiClientFactory;
    use GuzzleHttp\Client;
?>

<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/max_width.css">

    <title>Stock Bag</title>
    
    <link type="image/png" sizes="16x16" rel="icon" href="images/love-icons8-globe-16.png">
    
    <script>
   

    window.addEventListener("load", function() {
        document.getElementById("loading").style.display = "none";
        var d = new Date();
        var time = d.getHours();

        if (time >= 18 || time <= 6) {
        document.getElementById("loading").style.backgroundColor = "black";
        document.getElementById("loading").style.color = "white";
        } else {
        document.getElementById("loading").style.backgroundColor = "white";
        document.getElementById("loading").style.color = "black";
        }

        window.addEventListener('online', function() {
        document.getElementById("loading").style.display = "none";
        });

        window.addEventListener('offline', function() {
            document.getElementById("loading").style.display = "block";
            document.getElementById("loading").innerHTML = '<h1>Internetverbindung kann nicht hergestellt werden<i class="fa-solid fa-wifi-slash"></i></h1>';
        });
    });
        
    window.addEventListener('online', function() {
        document.getElementById("loading").style.display = "none";
    });

    window.addEventListener('offline', function() {
        document.getElementById("loading").style.display = "block";
        document.getElementById("loading").innerHTML = '<h1>Internetverbindung kann nicht hergestellt werden<i class="fa-solid fa-wifi-slash"></i></h1>';
    });
    </script>

    <style>
    #loading {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .loading-animation {
        margin-top: 5px;
        width: 50px;
        height: 50px;
        border: 5px solid #333;
        border-top-color: #f00;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
    
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="js/trade/pageClick.js"></script>
    
    <!-- <script defer type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
               
    <!-- <link async rel="stylesheet" href="css/trade_css/trade_cl_all.css">
    <link async rel="stylesheet" href="css/trade_css/trade_searchBar.css"> -->
    <!-- <link async rel="stylesheet" href="css/notification_css/notification.css"> -->
    
    <link async rel="stylesheet" href="css/trade_css/prefix/prefix_trade_cl_all.css">
    <link async rel="stylesheet" href="css/trade_css/prefix/prefix_trade_searchBar.css">
    <link async rel="stylesheet" href="css/notification_css/prefix_notification.css">

    <link async rel="stylesheet" href="css/trade_css/trade_modal.css">
    <link async rel="stylesheet" href="css/trade_css/trade_port.css">

    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    
</head>
<body>
<div id="allBody">

    <div id="loading">
        <h1 style="padding: 10px">Bitte warten Sie, die Seite wird geladen....</h1>
        <div class="loading-animation"></div>
    </div>

    <div id="mModal2" class="modal">
        <div class="modal-content bol-content">
            
            <div class="se_header">
                <div class="h2_s">
                    <h1>Verkaufen</h1>
                </div>

                <div class="h2_e">
                    <span class="close close1">&times;</span>
                </div>
            </div>
            
            <div class="real_modal_content bol">
                <div id="hiza" data-refresh-id="0">
                    <h3 id="div_stock_name">Sasa Polyester Sanayi A.S.</h3>
                    
                    <h1 id="div_money">2.375,13$</h1>
                    <h2 id="div_anteil">12</h2>
                    
                    <div id="div_range">
                        <h4 id="min_value" class="nocopy">1</h4>
                        <input id="input_range" type="range" min="0" max="1" class="nocopy">
                        <h4 id="max_value" class="nocopy">15</h4>
                    </div>

                    <button id="divide_button" class="expectSellButton">Verkaufen</button>
                </div>
            </div>
        </div>
    </div>


    <div class="alert hide alert-suc">  
        <span id="alert_icon" class="fas fa-exclamation-circle"></span>
        <span class="msg msg-suc">...</span>
        <div class="close-btn close-btn-suc">
            <span class="fas fa-times"></span>
        </div>
    </div>

    <div class="sidebarBack"></div>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="images/m3.png" alt="">
                </span>

                <div class="text logo-text">
                    <?php echo '<span class = "name">' . $_SESSION['user_name'] . ' ' . $_SESSION['user_lastname'] . '</span>'; ?>
                    <span class="profession">Welcome!</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
            <i id="sidebarMobileMenuButton" class="fa-solid fa-bars fa-xl"></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                
                <ul class="menu-links">
                    <li class="nav-link">
                        <a id="a_trade">
                            <i class='bx bx-home-alt icon' ></i>
                            <span class="text nav-text">Trade</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a id="a_port">
                            <i class='bx bx-bar-chart-alt-2 icon' ></i>
                            <span class="text nav-text">Portfolio</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a id="a_likes" title="Klicken Sie auf diesen Button, um den Post auf der Hauptseite zur Liste der Likes auf der Hauptseite hinzuzufügen.">
                            <i class='bx bx-heart icon' ></i>
                            <span class="text nav-text">Like</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="php/logout.php">
                        <i class='bx bx-log-out icon' ></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

                <li class="mode">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span id="darkorlightmode" class="mode-text text">Dark mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>
            
        </div>
    </nav>

    <section class="home">
        <div class="head padding-conf">
            <div class="hd_txt">
                <i id="mobileMenuButton" class="fa-solid fa-bars fa-xl"></i>
                <h1>Trade</h1>
            </div>
            <div class="hd_search autocomplete">
                <i id="hd_search_icon" class='fa-solid fa-magnifying-glass'></i>
                <input id="searchInput" class="" name="searchStocks" type="text" placeholder="Search stocks..">
            </div>   
        </div>

        <div id="main_div" class="padding-conf">
            <div class="buyStock">
                <div class="buyStockChild">
                    <div class="refreshSelectedStock">
                        <?php
                                $client = ApiClientFactory::createApiClient();
                                $options = [/* ... */];
                                $guzzleClient = new Client($options);
                                $client = ApiClientFactory::createApiClient($guzzleClient);
                                
                                // Returns Scheb\YahooFinanceApi\Results\Quote
                                $quote = $client->getQuote('AAPL'); 
                            
                                $nameShortOrLong = "";
                                $shortName = $quote->getShortName();
                                $longName = $quote->getLongName();
                                $rmPrice = $quote->getRegularMarketPrice();
                                $rmDayHigh = $quote->getRegularMarketDayHigh();
                                $rmDayLow = $quote->getRegularMarketDayLow();

                                $currency000 = $quote->getCurrency();
                                
                                $exchangeRate = $client->getExchangeRate($currency000, "EUR");
                                $rate = $exchangeRate->getAsk();

                                if(empty($longName)) {
                                    $nameShortOrLong = $shortName;
                                }
                                else {
                                    $nameShortOrLong = $longName;
                                }
                                echo "<div>
                                <h2 class='stock_name_gh stock_name_long_name' data-text=''>". $nameShortOrLong ."</h2>
                                </div>
                                <hr class='marginpaddingZero hrC' style='margin-top: 5px; margin-bottom: 10px;'>
                                
                                <div style='margin-top: 0.7rem; margin-bottom: 0.7rem'></div>
                                <div class='miniInfos'>
                                    <div class='mini mini1'>
                                        <span><i>Regular Market Price:</i><br><b>". number_format($rate * $rmPrice, 2, ',', '.') ." EUR</b></span>
                                    </div>
                                    <div class='mini mini2'>
                                        <span><i>Regular Market Day High:</i><br><b>". number_format($rate * $rmDayHigh, 2, ',', '.') ." EUR</b></span>	
                                    </div>
                                    <div class='mini mini3'>
                                        <span><i>Regular Market Day Low:</i><br><b>". number_format($rate * $rmDayLow, 2, ',', '.') ." EUR</b></span>
                                    </div>
                                </div>";
                                echo    "<div style='display: flex; justify-content: center; margin-top: 1rem'> 
                                            <select id='cart_select' style='width: 40%; font-size: 1rem'>
                                                <option selected value='-7 days'>-7 days</option>
                                                <option value='-14 days'>-14 days</option>
                                                <option value='-31 days'>-31 days</option>
                                                <option value='-93 days'>-93 days</option>
                                                <option value='-5 years'>-5 years</option>
                                            </select>
                                        </div>
                                    <canvas id='myChart' style='width:100%; margin-top: 0.5rem; margin-bottom: 1rem;'></canvas>";

                                

                            ?>
                            <script>
                                $(document).ready(function() {
                                    
                                    $('.close-btn').click(function(){
                                      $('.alert').removeClass("show");
                                        $('.alert').addClass("hide");
                                    });

                                    var xValues = [];
                                    var yValues = [];
                                    window.chart;

                                    function getData() {
                                        return $.ajax({
                                            type: 'POST',
                                            url : 'php/chart.php',
                                            data: {'searchType': "-7 days", 
                                                    'searchSymbol': $("#symb").html()}
                                        });
                                    }

                                    function handleData(data) {
                                        //do some stuff
                                        $sp_data = data.split("|||");
                                        

                                        for(var i=0; i<$sp_data.length; i++) {
                                            xValues.push($sp_data[i].split("-|-")[0]);
                                            yValues.push(parseFloat($sp_data[i].split("-|-")[1]).toFixed(2));
                                        } 
                                        
                                        window.chart = new Chart("myChart", {
                                        type: "line",
                                        data: {
                                            labels: xValues,
                                            datasets: [{
                                            fill: false,
                                            lineTension: 0,
                                            backgroundColor: "rgba(0,0,255,1.0)",
                                            //borderColor: "rgba(0,0,255,0.1)",
                                            borderColor: "rgba(0,0,255,0.5)",
                                            data: yValues
                                            }]
                                        },
                                        options: {
                                            legend: {display: false},
                                            scales: {
                                            yAxes: [{ticks: {min: Math.floor(Math.min(...yValues)), max: Math.ceil(Math.max(...yValues))}}],
                                            }
                                        }
                                        });
                                        
                                    }

                                    getData().done(handleData);

                                    $("#cart_select").change(function() {
                                        var chart_val = $("#cart_select").val();

                                        function getData() {
                                             return $.ajax({
                                                type: 'POST',
                                                url : 'php/chart.php',
                                                data: {'searchType': chart_val, 
                                                        'searchSymbol': $("#symb").html()}
                                            });
                                        }

                                        function handleData(data) {
                                            
                                            $sp_data = data.split("|||");

                                            //x tarih - $sp_data[0]
                                            //y para    $sp_data[1]

                                            xValues = [];
                                            yValues = [];

                                            for(var i=0; i<$sp_data.length; i++) {
                                                xValues.push($sp_data[i].split("-|-")[0]);
                                                yValues.push(parseFloat($sp_data[i].split("-|-")[1]).toFixed(2));
                                            } 
                                            window.chart.destroy();
                                            window.chart = new Chart("myChart", {
                                            type: "line",
                                            data: {
                                                labels: xValues,
                                                datasets: [{
                                                    fill: false,
                                                    lineTension: 0,
                                                    backgroundColor: "rgba(0,0,255,1.0)",
                                                    //borderColor: "rgba(0,0,255,0.2)",
                                                    borderColor: "rgba(0,0,255,0.5)",
                                                    data: yValues
                                                }]
                                            },
                                            options: {
                                                legend: {display: false},
                                                scales: {
                                                yAxes: [{ticks: {min: Math.floor(Math.min(...yValues)), max: Math.ceil(Math.max(...yValues))}}],
                                                }
                                            }
                                            });
                                        }

                                        getData().done(handleData);
                                    });
                                    
                                    /* var resetCanvas = function(){
                                        $('#results-graph').remove(); // this is my <canvas> element
                                        $('#graph-container').append('<canvas id="results-graph"><canvas>');
                                        canvas = document.querySelector('#results-graph');
                                        ctx = canvas.getContext('2d');
                                        ctx.canvas.width = $('#graph').width(); // resize to parent width
                                        ctx.canvas.height = $('#graph').height(); // resize to parent height
                                        var x = canvas.width/2;
                                        var y = canvas.height/2;
                                        ctx.font = '10pt Verdana';
                                        ctx.textAlign = 'center';
                                        ctx.fillText('This text is centered on the canvas', x, y);
                                    }; */

                                });
                                
                            </script>
                            <script>
                                $( document ).ready(function() {
                                    var s_max = 20;
                                    var s = s_max;
                                    var interval60 = setInterval(function() {

                                        if(s % 2 == 0) {
                                            $.ajax({
                                                type: 'POST',
                                                url: 'php/isActive.php',
                                                success: function(data){
                                                    if(data != "1") {
                                                        location.reload();
                                                    }
                                                }
                                            });
                                        }

                                        --s;
                                        if(s < 1) {
                                            s = s_max;
                                            calls_thrd();
                                        };
                                        //$('.stock_name_long_name').attr('data-text', s);
                                    }, 1000);

                                    function calls_thrd() {
                                        $.ajax({
                                            type: 'POST',
                                            url: 'php/tableYah.php',
                                            data: {'selectedStock': $("#symb").html()},
                                            success: function(data){
                                                //document.getElementById("tablegh").innerHTML = data;
                                                //document.getElementsByClassName("tablegh").innerHTML = data;
                                                $(".tablegh").html(data);
                                            }
                                        });

                                        $.ajax({
                                            type: 'POST',
                                            url: 'php/mininfo.php',
                                            data: {'miniInfo': $("#symb").html()},
                                            success: function(data){
                                                var dataSplitted = data.split("{-}");
                                                $('.stock_name_long_name').html(dataSplitted[0]);
                                                $('.mini1').html("<span><i>Regular Market Price:</i><br><b>" + dataSplitted[1] + " EUR</b></span>");
                                                $('.mini2').html("<span><i>Regular Market Day High:</i><br><b>" + dataSplitted[2] + " EUR</b></span>");
                                                $('.mini3').html("<span><i>Regular Market Day Low:</i><br><b>" + dataSplitted[3] + " EUR</b></span>");

                                                var inQu = $("#inputQuantity").val();
                                                if(inQu === "") {
                                                    $("#mengeQuantity").val("");
                                                }
                                                else {
                                                    var snc = (parseFloat(inQu) * parseFloat(dataSplitted[1].replace(",", "."))).toFixed(2);
                                                    snc = snc.replace('.', ',');
                                                    $("#mengeQuantity").val(snc + " EUR");
                                                }
                                            }
                                        });
                                    }
                                });
                            </script>

                    </div>
                    
                    <div class="quantityBox">
                        <form>
                            <div id="qBoxLastChild">
                                <div class="qqChild" style="display: flex; flex-direction: row; align-items: center; margin-right: 5px;">
                                    <h3 style="padding: 0; margin: 0; margin-right: 5px;">Anteil: </h3>
                                    <input id="inputQuantity" name="inputQuantityName" type="number" placeholder="Anteil" step="any" style="font-size: 1.15rem; width: 100%" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9*]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                                <div class="qqChild" style="display: flex; flex-direction: row; align-items: center; margin-right: 5px;">
                                    <h3 style="padding: 0; margin: 0; margin-right: 5px;">Schätzpreis: </h3>
                                    <input id="mengeQuantity" name="mengeQuantity" type="text" placeholder="Schätzpreis" readonly style="cursor: no-drop; font-size: 1.15rem; width: 100%">
                                </div>
                                <script>
                                    $( document ).ready(function() {
                                        
                                        $("#inputQuantity").on("input", function(e) {

                                            if (this.value.length > 9) {
                                                this.value = this.value.slice(0,9);
                                                return;
                                            }

                                            if($(this).val().length === 1 && $(this).val() === "0" || $(this).val() === 0) {
                                                $(this).val("");
                                                return;
                                            }

                                            if($(this).val() === "") {
                                                $("#mengeQuantity").val("");
                                            }

                                            if($(this).val() !== "" && $(this).val().length !== 0) {
                                                var rmp = $("#rmp").html().split(' ')[0];
                                                var lot = $(this).val();

                                                rmp = rmp.replace(",", ".");
                                                var snc = (parseFloat(rmp) * parseFloat(lot)).toFixed(2);
                                                snc = snc.replace('.', ',');
                                                $("#mengeQuantity").val(snc + " EUR"); 
                                            }
                                        });
                                    });
                                </script>
                                <!--
                                <div class="qqChild" style="display: flex; flex-direction: row; align-items: center; margin-left: 5px;">
                                    <h3 style="padding: 0; margin: 0; margin-right: 5px;">Quantity type: </h3>
                                    <div class="select-dropdown">
                                        <select name="quantityTypeInput" id="quantityTypeInput" style="margin-top: 2px; font-size: 1.15rem;">
                                            <option value="€ Euro">€ Euro</option>    
                                            <option value="$ Dollar">$ Dollar</option>
                                        </select> 
                                    </div>
                                </div>
                                -->
                            </div>
                        </form>
                    </div>
                    <div id="requireDiv" style="display: none; justify-content: center;">
                        <span style="padding-top: 10px; color: red;">Bitte geben Sie den Betrag ein, den Sie erhalten möchten</span>
                    </div>
                    <div class="buttonBox">
                        <button id="sendBuyReq" type="button">Zum Portfolio Hinzufügen</button>
                    </div>
                    <script>
                        $(document).ready(function() {
                            function greenNotSet(text, time) {
                                $(".alert").removeClass("alert-red");
                                
                                $(".msg").removeClass("msg-red");

                                $('.close-btn').removeClass('close-btn-red');

                                $('.alert #alert_icon').attr("class", "msg-suc fa-solid fa-circle-check fa-2xl");
                                $('.msg').html(text);

                                //next
                                $('.alert').addClass("show");
                                $('.alert').removeClass("hide");
                                $('.alert').addClass("showAlert");
                                
                                setTimeout(function(){
                                $('.alert').removeClass("show");
                                $('.alert').addClass("hide");
                                }, time);
                            }

                            function redNotSet(text, time) {
                                $(".alert").addClass("alert-red");
                                
                                $(".msg").addClass("msg-red");

                                $('.close-btn').addClass('close-btn-red');

                                $('.alert #alert_icon').attr("class", "msg-red fa-solid fa-circle-xmark fa-2xl");
                                $('.msg').html(text);

                                //next
                                $('.alert').addClass("show");
                                $('.alert').removeClass("hide");
                                $('.alert').addClass("showAlert");
                                
                                setTimeout(function(){
                                $('.alert').removeClass("show");
                                $('.alert').addClass("hide");
                                }, time);
                            }

                            $('#sendBuyReq').on('click', function(e) {

                                if($('#inputQuantity').val() === "") {
                                    /*
                                    $('#requireDiv').children().html("Bitte geben Sie den Betrag ein, den Sie erhalten möchten");
                                    $('#requireDiv').css("display", "flex");
                                    $('#requireDiv').children().css("color", "red");
                                    */
                                    redNotSet("Bitte geben Sie den Betrag ein, den Sie erhalten möchten", 4000);
                                    return false;
                                } else {
                                    $.ajax({
                                        type: 'POST',
                                        url: 'php/stock_request.php',
                                        data: {'stocks': $('.stock_name_long_name').html(),
                                                'quantity': $('#inputQuantity').val(),
                                                //'quantityType': $('#quantityTypeInput').val()},
                                                /* 'anteil_price': $(".mini1 span b").html(), */
                                                /* 'anteil_price': $('#mengeQuantity').val() + "|-|" + $('#inputQuantity').val(), */
                                                'sch': $('#mengeQuantity').val(),
                                                'add_symbol': $('#symb').html()
                                                },
                                        success: function(data){
                                            greenNotSet("Erfolgreich gekauft. Sie können Ihren Bestand verfolgen, indem Sie auf die Schaltfläche „Portfolio“ klicken.", 5000);
                                            //$('.tablestocks > tbody:last-child').append($(data));
                                            //$('.tablestocks').prepend($(data));
                                            //$(".tablestocks tbody tr:first").after(data).fadeIn();
                                           
                                            var row = $(data);
                                            row.hide();
                                            $(".tablestocks tbody tr:first").after(row);
                                            row.fadeIn("slow");
                                        }
                                    });
                                    $('#inputQuantity').val("");
                                    $('#mengeQuantity').val("");
                                }
                            });

                        });
                    </script>
                </div>

                <div class="buyStockChild transac" style="margin-top: 20px;">
                    <h2 class="stock_name_gh"><i class="fa-solid fa-clock-rotate-left"></i> Vergangene Suchen</h2>
                    <hr class="marginpaddingZero hrC" style="margin-top: 5px; margin-bottom: 10px;">
                    <div style="overflow: auto;  -webkit-overflow-scrolling: touch; max-height: 550px;">
                        <table class="tablef iTable" id="lookHistoryTable" style="margin-bottom: 10px">
                            <tr>
                                <th>Aktienname</th>
                                <th>Preis</th>
                                <th>Zeit</th>
                                <th>Datum</th>
                            </tr>
                            <?php 
                                include dirname(__FILE__)."\php\getLookedHistory.php";
                            ?>
                        </table>
                    </div>
                </div>

            </div>

            <div class="fiyuv">
                <div class="tablegh">
                    
                    <?php
                        // Create a new client from the factory
                        $client = ApiClientFactory::createApiClient();

                        // Or use your own Guzzle client and pass it in
                        $options = [/* ... */];
                        $guzzleClient = new Client($options);
                        $client = ApiClientFactory::createApiClient($guzzleClient);
                        
                        // Returns Scheb\YahooFinanceApi\Results\Quote
                        $quote = $client->getQuote("AAPL"); 

                        $crn = " EUR";
                        $preMarketTime = $quote->getPreMarketTime();
                        $dividendDate = $quote->getDividendDate();
                        $earningsTimestamp = $quote->getEarningsTimestamp();
                        $earningsTimestampStart = $quote->getEarningsTimestampStart();
                        $earningsTimestampEnd = $quote->getEarningsTimestampEnd();
                        $regularMarketTime = $quote->getRegularMarketTime();

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
                </div>
                
                <div class="buyStockChild transac" style="margin-top: 20px;">
                    <h2 class="stock_name_gh"><i class="fa-solid fa-heart"></i> Likes</h2>
                    <hr class="marginpaddingZero hrC" style="margin-top: 5px; margin-bottom: 10px;">
                    <div style="overflow: auto;  -webkit-overflow-scrolling: touch; max-height: 550px;">
                        <table class="tablef iTable" id="likesTable" style="margin-bottom: 10px">
                            <tr>
                                <th>Aktienname</th>
                                <th>Preis</th>
                                <th>Datum</th>
                                <th>Löschen</th>
                            </tr>
                            <?php 
                                include dirname(__FILE__)."\php\likes_get_list.php";
                            ?>
                        </table>
                    </div>
                </div>

                <script>
                    $(document.body).on('click', '.removeLike', function() {
                        var clicked_input = $(this).parent().parent();
                        var data_id = $(this).parent().parent().attr('data-like-id');
                        $.ajax({
                            type: 'POST',
                            url: 'php/likes_delete_event.php',
                            data: {'like_row_id': data_id},
                            success: function(data){
                                    if(data == "l_r_s") {
                                        clicked_input.fadeOut(300, function() {
                                            $(this).remove();
                                        });
                                    }
                                }
                        });
                    })
                </script>

                
                
            </div>
        </div>

        <div id="port" class="padding-conf">
        
            <div class="centerHead">
                <h1 class="headerForH1">Inventar</h1>
            </div>

            <br>
            <div class="real_inventar">
                <?php
                    include dirname(__FILE__)."\php\port_all_envanter_update.php";
                ?>
            </div>
                <script>
                    $( document ).ready(function() {

                        window.port_all_envanter = function () {
                            return $.ajax({
                                type: 'POST',
                                url: 'php/port_all_envanter_update.php',
                                success: function(data){
                                        $(".real_inventar").html(data);
                                    }
                            });
                        }

                        window.refresh_anteil_price = function () {
                            var dataRefreshId = $("#hiza").attr("data-refresh-id");
                            if(dataRefreshId != "0") {
                                var div_money = $("#div_money");
                                var sht = $(".real_inventar tbody tr[data-id='"+ dataRefreshId +"']").children().eq(4).html();
                                var ex = (parseFloat(sht.split(" ")[0].replace(/\./g, "").replace(",", ".")) * $("#input_range").val()).toFixed(2);
                                var nmbr = String(ex).replace(".", ",").split(",");
                                div_money.html(nmbr[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".") + "," + nmbr[1] + " EUR");
                            }
                        }
                        setInterval(function() {
                            window.port_all_envanter().done(window.refresh_anteil_price);
                        }, 60000);
                    })
                </script>
            
            <br>
            <br>
            <br>
            
            <hr class="hrBottom">
            <br>
            <div class="centerHead">
                <h1 class="headerForH1">Verkaufsliste</h1>
            </div>
            <br>
            
            <div class="inventarList sellList">
                <table>
                    <thead>
                        <tr>
                            <th>Stock Name</th>
                            <th>Menge der verkauften Teile</th>
                            <th>Kaufpreis</th>
                            <th>der Betrag</th>
                            <th>Verkaufspreis</th>
                            <th>Gewinn-Verlust-Verhältnis</th>
                            <th>Verkaufsdatum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include dirname(__FILE__)."\php\sell_list.php";
                        ?>
                    </tbody>
                </table>
            </div>

            <br>
            <br>
            
        </div>
        
    </section>
    
    <!-- //! Menu script -->
    <script>
        $(document).ready(function() {

            /* 
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(function() {
                drawChart(1);
            });
             */

            const body = document.querySelector('body'),
            sidebar = body.querySelector('nav'),
            toggle = body.querySelector(".toggle"),
            //searchBtn = body.querySelector(".search-box"),
            modeSwitch = body.querySelector(".toggle-switch"),
            modeText = body.querySelector(".mode-text");
           

                checkWidth();

                toggle.addEventListener("click" , function() {
                    sidebar.classList.toggle("close");
                })


                var getMode = localStorage.getItem("mode");

                if(getMode == "dark-mode") {
                    body.classList.toggle("dark");
                    modeText.innerText = "Light mode";
                    //dark mode,

                    /* $("nav").css("background-color", "#242526");
                    $("nav").css("color", "black");
                    $("nav a").css("color", "white"); */

                    $("#port").css("color", "white");

                    $(".modal-content").css("background-color", "#000000");
                    $(".modal-content").css("color", "white");
                    $(".se_header").css("color", "black");
                    $(".se_header").css("border-top-left-radius", "10px");
                    $(".se_header").css("border-top-right-radius", "10px");
                    $(".se_header").css("background-color", "white");

                    $(".toggle").css("background-color", "white");
                    $(".toggle").css("color", "black");
                    $("#sidebarMobileMenuButton").css("color", "white");
                    $(".buyStockChild").css("background-color", "black");
                    $(".buyStockChild").css("color", "white");
                    $(".tablef").css("background-color", "black");
                    
                    $(".tablegh").css("background-color", "black");
                    $(".tablegh").css("color", "white");
                    $("#searchInput").css("color", "white");
                    $(".head").css("background-color", "#4300ff");

                    $("#cart_select").css("background-color", "black");
                    $("#cart_select").css("color", "white");
                } 
                else {
                    modeText.innerText = "Dark mode";

                    //light mode
                    /* $("nav").css("background-color", "white");
                    $("nav").css("color", "black");
                    $("nav a").css("color", "grey") */;
                    $("#port").css("color", "black");

                    $(".modal-content").css("background-color", "white");
                    $(".modal-content").css("color", "black");
                    $(".se_header").css("color", "black");
                    $(".se_header").css("border-top-left-radius", "10px");
                    $(".se_header").css("border-top-right-radius", "10px");
                    $(".se_header").css("background-color", "white");


                    $(".toggle").css("background-color", "#282bff");
                    $(".toggle").css("color", "white");
                    $("#sidebarMobileMenuButton").css("color", "black");
                    $(".buyStockChild").css("background-color", "white");
                    $(".buyStockChild").css("color", "black");
                    $(".tablef").css("background-color", "white");

                    $(".tablegh").css("background-color", "white");
                    $(".tablegh").css("color", "black");
                    $("#searchInput").css("color", "black");
                    $(".head").css("background-color", "#338fd0");

                    $("#cart_select").css("background-color", "white");
                    $("#cart_select").css("color", "black");
                }

                modeSwitch.addEventListener("click" , function() {
                    body.classList.toggle("dark");
                    
                    if(body.classList.contains("dark")){

                        localStorage.setItem("mode", "dark-mode");

                        modeText.innerText = "Light mode";

                        /* $("nav").css("background-color", "#242526");
                        $("nav").css("color", "black");
                        $("nav a").css("color", "white"); */

                        //dark mode
                        $("#port").css("color", "white");

                        $(".modal-content").css("background-color", "#000000");
                        $(".modal-content").css("color", "white");
                        $(".se_header").css("color", "black");
                        $(".se_header").css("border-top-left-radius", "10px");
                        $(".se_header").css("border-top-right-radius", "10px");
                        $(".se_header").css("background-color", "white");

                        $(".toggle").css("background-color", "white");
                        $(".toggle").css("color", "black");
                        $("#sidebarMobileMenuButton").css("color", "white");
                        $(".buyStockChild").css("background-color", "black");
                        $(".buyStockChild").css("color", "white");
                        $(".tablef").css("background-color", "black");
                        
                        $(".tablegh").css("background-color", "black");
                        $(".tablegh").css("color", "white");
                        $("#searchInput").css("color", "white");
                        $(".head").css("background-color", "#4300ff");

                        $("#cart_select").css("background-color", "black");
                        $("#cart_select").css("color", "white");

                    }else{
                        localStorage.setItem("mode", "light-mode");

                        modeText.innerText = "Dark mode";

                        /* $("nav").css("background-color", "white");
                        $("nav").css("color", "black");
                        $("nav a").css("color", "grey");
                        $("nav").css("background-color", "white"); */

                        //light mode
                        $("#port").css("color", "black");

                        $(".modal-content").css("background-color", "white");
                        $(".modal-content").css("color", "black");
                        $(".se_header").css("color", "black");
                        $(".se_header").css("border-top-left-radius", "10px");
                        $(".se_header").css("border-top-right-radius", "10px");
                        $(".se_header").css("background-color", "white");

                        $(".toggle").css("background-color", "#282bff");
                        $(".toggle").css("color", "white");
                        $("#sidebarMobileMenuButton").css("color", "black");
                        $(".buyStockChild").css("background-color", "white");
                        $(".buyStockChild").css("color", "black");
                        $(".tablef").css("background-color", "white");

                        $(".tablegh").css("background-color", "white");
                        $(".tablegh").css("color", "black");
                        $("#searchInput").css("color", "black");
                        $(".head").css("background-color", "#338fd0");

                        $("#cart_select").css("background-color", "white");
                        $("#cart_select").css("color", "black");
                    }
                });

                var touchmoveHandler = function(event) {
                    event.preventDefault();
                };

                window.onresize = function() {
                    checkWidth();
                };

                function checkWidth() {

                    //850pxA
                    if (window.innerWidth <= 850) {
                        //sidebar.classList.toggle("close");
                        if (sidebar.classList.contains('close')) {
                            sidebar.classList.toggle("close");
                        }

                        $(".sidebar").css("display", "none");
                        $(".sidebarBack").css("display", "none");

                        //window.addEventListener("touchmove", touchmoveHandler, { passive: false });
                    }
                    else {
                        if (!sidebar.classList.contains('close')) {
                            sidebar.classList.toggle("close");
                        }
                        
                        $(".sidebar").css("display", "block");
                        $(".sidebarBack").css("display", "none");

                        //window.removeEventListener("touchmove", touchmoveHandler, { passive: false });
                    }
                }

                $("#mobileMenuButton").on("click", function() {

                    $(".sidebar").css("display", "block");
                    $(".sidebarBack").css("display", "block");
                    
                    //$(".sidebarBack").css("overflow", "hidden");
                    //document.querySelector(".sidebar").removeEventListener("touchmove", touchmoveHandler, { passive: false });
                })
                $("#sidebarMobileMenuButton").on("click", function() {

                    $(".sidebar").css("display", "none");
                    $(".sidebarBack").css("display", "none");
                    //$(".sidebarBack").css("overflow", "");

                    
                })
                
                $(".sidebarBack").on("pointerdown click touchstart", function() {
                    $(".sidebar").css("display", "none");
                    $(".sidebarBack").css("display", "none");
                    
                });          
    });        

    </script>


    <script>
        $(document.body).on('click', '.cancelRequest', function() {
            var clicked_input = $(this).parent().parent();
            var data_id = $(this).parent().parent().attr('data-id');
            $.ajax({
                type: 'POST',
                url: 'php/stock_transaction_delete.php',
                data: {'row_id': data_id},
                success: function(data){
                        if(data != "error") {
                            clicked_input.fadeOut(300, function() {
                                $(this).remove();
                            });
                        }
                    }
            });
        })
    </script>


    <script>
        var searchs = [];

        document.getElementById("searchInput").addEventListener("keyup", function(e) {
            gogo();
        });

        $('#hd_search_icon').on('click', function() {
            gogo();
        });

        function gogo() {
            var text = document.getElementById("searchInput").value;
            if (text === "") {
                closeAllLists();
                return false;
            }
            goSearchBarPhp(text).then( function(response) {
                
                if(searchs.length !== 0) {
                    while (searchs.length > 0) {
                        searchs.pop();
                    }
                }
                var res = response.split("<|>");
                var resCount = res.length;
                
                for(var i=0; i<resCount-1; i++) {
                    searchs.push(res[i]);
                }

                $("#hd_search_icon").attr("class", "fa-solid fa-magnifying-glass");

                if(searchs.length == 0) {
                    autocomplete(document.getElementById("searchInput"), searchs);
                    document.getElementById("searchInputautocomplete-list").remove();
                    return false;
                }
                else {
                    autocomplete(document.getElementById("searchInput"), searchs);
                }
                
                
            });
        }

        function goSearchBarPhp (text) {

            $("#hd_search_icon").attr("class", "fa-solid fa-arrows-rotate rotating");


            return $.ajax({
                type: 'POST',
                url: 'php/searchBar.php',
                data: {'srcTxt': text}
            });
        }
        
        function autocomplete(inp, arr) {

            var currentFocus;
            autoCompleteChild(inp, arr);

            /* inp.addEventListener("input", function(e) {
                autoCompleteChild(inp, arr);
            }); */

            inp.addEventListener(inp, function(e) {
                autoCompleteChild(inp, arr);
            });
            inp.addEventListener("keydown", function(e) {

                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    currentFocus++;
                    addActive(x);
                } else if (e.keyCode == 38) {
                    currentFocus--;
                    addActive(x);
                } else if (e.keyCode == 13) {
                    e.preventDefault();
                    if (currentFocus > -1) {
                    if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                if (!x) return false;
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                x[currentFocus].classList.add("autocomplete-active");
            }
            function removeActive(x) {
                for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
                }
            }
            
            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });
        }

        function autoCompleteChild(inp, arr) {

            var a, b, i, val = inp.value;
            closeAllLists();
            if (!val) { return false;}
            currentFocus = -1;
            a = document.createElement("DIV");
            a.setAttribute("id", inp.id + "autocomplete-list");

            if(document.querySelector("body").classList.contains("dark")){
                a.setAttribute("class", "autocomplete-items night-complete");
            }
            else {
                a.setAttribute("class", "autocomplete-items sun-complete");
            }

            inp.parentNode.appendChild(a);
            for (i = 0; i < arr.length; i++) {
                if (arr[i].substr(0, val.length).toLowerCase() == val.toLowerCase()) {
                    b = document.createElement("DIV");
                    b.setAttribute("class", "getTextClicked");
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";

                    var breakthat = false;

                    //! Burada hata yaşandığı zaman echo olarak php veriyor

                    b.addEventListener("click", function(e) {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        $txtInp = inp.value;
                        $txtInp = $txtInp.split(" - ");
                        $.ajax({
                            type: 'POST',
                            url: 'php/tableYah.php',
                            data: {'selectedStock': $txtInp[1]},
                            success: function(data){
                                //document.getElementById("tablegh").innerHTML = data;
                                //document.getElementsByClassName("tablegh").innerHTML = data;
                                $(".tablegh").html(data);
                                getData().done(handleData);
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: 'php/mininfo.php',
                            data: {'miniInfo': $txtInp[1]},
                            success: function(data){
                                var dataSplitted = data.split("{-}");
                                $('.stock_name_long_name').html(dataSplitted[0]);
                                $('.mini1').html("<span><i>Regular Market Price:</i><br><b>" + dataSplitted[1] + " EUR</b></span>");
                                $('.mini2').html("<span><i>Regular Market Day High:</i><br><b>" + dataSplitted[2] + " EUR</b></span>");
                                $('.mini3').html("<span><i>Regular Market Day Low:</i><br><b>" + dataSplitted[3] + " EUR</b></span>");

                                $.ajax({
                                    type: 'POST',
                                    url: 'php/lookHistory.php',
                                    data: {'lookedStock': inp.value,
                                            'lookedPrice': dataSplitted[1]},
                                    success: function(data){
                                        var valueLooked = inp.value;

                                        var currentdate = new Date(); 
                                        var day0 = currentdate.getDate().toString().padStart(2, '0');
                                        var month0 = (currentdate.getMonth() + 1).toString().padStart(2, '0');
                                        var year = currentdate.getFullYear();
                                        year = year.toString().slice(-2);

                                        var timeRightNow = currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
                                        var dateRightNow = day0 + "."+ month0 + "." + year;

                                        var rowString = "<tr><td>"+ valueLooked +"</td><td>"+ $(".mini1 span b").html() +"</td><td>"+ timeRightNow +"</td><td>"+ dateRightNow +"</td></tr>"
                                        //$('#lookHistoryTable').find('tbody').append(rowString);

                                         /*                                    
                                        var rows = $('<tr><td>text</td></tr>');
                                        rows.hide();
                                        $('tr:last-child').after(rows);
                                        rows.fadeIn("slow");
                                        */

                                        var historyRow = $(rowString);
                                        historyRow.hide();
                                        $("#lookHistoryTable tbody tr:first").after(historyRow);
                                        historyRow.fadeIn("slow");
                                        
                                        //$("#lookHistoryTable tbody tr:first").after(rowString);
                                    }
                                });
                            }
                        });

                        

                        $("#inputQuantity").val("");
                        $("#mengeQuantity").val("");
                        $("#mengeQuantity").attr("placeholder", "Schätzpreis");

                        $("#cart_select").val('-7 days');

                        

                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        }
        function getData() {
        return $.ajax({
            type: 'POST',
            url : 'php/chart.php',
            data: {'searchType': "-7 days", 
                    'searchSymbol': $("#symb").html()}
            });
        }

        function handleData(data) {
            $sp_data = data.split("|||");
            
            xValues = [];
            yValues = [];

            for(var i=0; i<$sp_data.length; i++) {
                xValues.push($sp_data[i].split("-|-")[0]);
                yValues.push(parseFloat($sp_data[i].split("-|-")[1]).toFixed(2));
            } 
            window.chart.destroy();
            window.chart = new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(0,0,255,1.0)",
                //borderColor: "rgba(0,0,255,0.1)",
                borderColor: "rgba(0,0,255,0.5)",
                data: yValues
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                yAxes: [{ticks: {min: Math.floor(Math.min(...yValues)), max: Math.ceil(Math.max(...yValues))}}],
                }
            }
            });
        }
        function closeAllLists(elmnt) {
                var inp = document.getElementById("searchInput");
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
        }
    </script>
    </div>
</body>
</html>
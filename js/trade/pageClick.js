//1- a_trade

//2- a_port

//3- a_noti

//4- a_likes

//5- a_wallet

$( document ).ready(function() {

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
   
    
    var modal2 = document.getElementById("mModal2");
    var hiza = $("#hiza");

    document.addEventListener("keydown", function(event) {
        if (event.key === "Escape" || event.key === "Esc" || event.keyCode === 27) {
            modal2.style.display = "none";
            hiza.attr("data-refresh-id", "0");
        }
    });

    var span = document.getElementsByClassName("close1")[0];
    span.onclick = function() {
        modal2.style.display = "none";
        hiza.attr("data-refresh-id", "0");
    }

    window.onclick = function(event) {
        if (event.target == modal2) {
            modal2.style.display = "none";
            hiza.attr("data-refresh-id", "0");
            
        }
    }

    var a_liked_button = document.getElementById("a_likes");
        
    a_liked_button.onclick = function() {
        var stockName = $(".stock_name_long_name").html();
        var regularMarketPrice = $(".mini1 span b").html();

        //! Bu kısım ecmascript 6 ile yazıldığı için eski tarayıcılarda çalışmayacaktır.
        var firstColumnValues = $("#likesTable tr td:first-child").map(function() {
            return $(this).text();
        }).get();

        var isTrue = firstColumnValues.includes(stockName);

        if(isTrue) {
            return;
        }
        else {
            $.ajax({
                type: "POST",
                url: "php/likes_add_to_list.php",
                data: {
                    "likedStock": stockName,
                    "likedPrice": regularMarketPrice
                },
                dataType: "text",
                success: function(res) {
                    var historyRow = $(res);
                    historyRow.hide();
                    $("#likesTable tbody tr:first").after(historyRow);
                    historyRow.fadeIn("slow");
                }
            });
        }
    }
    
    var a_tradeMain = document.getElementById("a_trade");
    var main_div = document.getElementById("main_div");
    var port_div = document.getElementById("port");

    main_div.style.display = "block";
    port_div.style.display = "none";
    
    a_tradeMain.onclick = function() {
        main_div.style.display = "block";
        port_div.style.display = "none";

        $(".hd_txt h1").html("Trade");
        $(".hd_search").css("visibility", "visible");
    }

    var a_port = document.getElementById("a_port");
    a_port.onclick = function() {
        main_div.style.display = "none";
        port_div.style.display = "block";

        //! adam her bastığında yenilenmesi daha iyi.

        window.port_all_envanter().done(window.refresh_anteil_price);
                    
        $.ajax({
            url: "php/sell_list.php",
            success: function(response) {
                $(".sellList tbody").html(response);
            }
        });
        $(".hd_txt h1").html("Portfolio");
        $(".hd_search").css("visibility", "hidden");

    }

    var div_stock_name = $("#div_stock_name");

    var div_money = $("#div_money");
    var div_anteil = $("#div_anteil");

    var min_value = $("#min_value");
    var max_value = $("#max_value");

    var input_range = $("#input_range");

    var divide_button = $("#divide_button");

    window.div_anteil_price = 0;
    
    $(document).on('click', '.sellStockButton', function(){

        var parent = $(this).parent().parent().children();

        var trDataId = $(this).parent().parent().attr("data-id");
        hiza.attr("data-refresh-id", trDataId);

        div_stock_name.html(parent.eq(0).html());

        div_money.html(parent.eq(6).html());
        div_anteil.html(parent.eq(1).html());

        if(parent.eq(1).html() == "1") {
            min_value.html("0");
            max_value.html(1);

            input_range.attr("min", "0");
            input_range.prop("disabled", true);
            input_range.attr("min", "0");
            input_range.attr("max", "1");
            input_range.val(1);
        }
        else {
            min_value.html("1");
            input_range.attr("min", "1");
            max_value.html(parent.eq(1).html());
            input_range.attr("max", parent.eq(1).html());
            input_range.prop("disabled", false);
            input_range.val(parent.eq(1).html());
        }

        modal2.style.display = "block";

        input_range.on("input", function() {
            div_anteil.html($(this).val()); 

            //var ex = (parseFloat(parent.eq(4).html().split(" ")[0].replace(/\./g, "").replace(",", ".")) * $(this).val()).toFixed(2);
            var dataRefreshId = $("#hiza").attr("data-refresh-id");
            var sht = $(".real_inventar tbody tr[data-id='"+ dataRefreshId +"']").children().eq(4).html();
            var ex = (parseFloat(sht.split(" ")[0].replace(/\./g, "").replace(",", ".")) * $(this).val()).toFixed(2);
            //exV2^

            //let formattedNumber = number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");,
            var nmbr = String(ex).replace(".", ",").split(",");
            div_money.html(nmbr[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".") + "," + nmbr[1] + " EUR");
        });
        
        

        //console.log(trDataId);
        //kapatıldığında bütün değerleri sil

        
      });

      divide_button.on("click", function() {
        
        var dataRefreshId = $("#hiza").attr("data-refresh-id");
        var inputRange = $("#input_range").val();

        $.ajax({
            type: "POST",
            url: "php/divide_stock.php",
            data: {
                'dataRefreshId': dataRefreshId,
                'inputRange': inputRange
            },
            success: function (res) {
                
                if(res == 1) {
                    window.port_all_envanter().done(window.refresh_anteil_price);
                    
                    $.ajax({
                        url: "php/sell_list.php",
                        success: function(response) {
                            $(".sellList tbody").html(response);
                        }
                    });

                    greenNotSet("Transaktion Erfolgreich.", 2000);
                }
                if(res == 2) {
                    redNotSet("Wir können Ihre Anfrage derzeit nicht erfüllen. Versuchen Sie es in ein paar Minuten erneut.", 4000);
                }

            }
        });

        modal2.style.display = "none";
        hiza.attr("data-refresh-id", "0");

      });


});
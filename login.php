<!DOCTYPE html>

<?php

    session_start();
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == "1") {
        header('Location: trade.php');
    }
    else {
        session_destroy();
    }

?>
<html lang="tr">
<head>
    <title>Login</title>    

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="image/png" sizes="16x16" rel="icon" href="images/love-icons8-globe-16.png">
    
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/max_width.css">
    
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/popUpModalStyle.css">
    <script defer src="js/login/popUpModal.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/login/input.js"></script>


    <link rel="stylesheet" href="css/notification_css/notification.css">

</head>
<body style="background-image: url('images/login2.png'); font-family: Helvetica, Arial, sans-serif">

    <div class="alert hide alert-suc">  
        <span id="alert_icon" class="fas fa-exclamation-circle"></span>
        <span class="msg msg-suc">...</span>
        <div class="close-btn close-btn-suc">
            <span class="fas fa-times"></span>
        </div>
    </div>

    <div id="loginBox">
        <div class="topLogo" style="text-align: center;">
            <img style="width: 250px; height: 250px;" src="images/m3.png" alt="Logo">
        </div>
        <div class="info">
            <div style="text-align: center;">
                <p><b style="color: white;">Online-Bestellplattform</b></p>
            </div>
        </div>
        <div style="margin-top: 20px;">
            <div style="text-align: center;">
                <b class="loginError" style="color: #d4d4d4;">Melden Sie sich bei Ihrem Konto an</b>
            </div>
            <form id="loginForm">
                <div style="text-align: center;">
                    <div class="labelInput">
                        <label for="email"><b></b></label>
                        <input id="login_email" required="required" class="inputStyle" type="email" name="email" placeholder="E-Mail Addresse">
                    </div>
                    <div class="labelInput">
                        <label for="password"></label>
                        <input id="login_password" required="required" class="inputStyle" type="password" name="password" placeholder="Passwort">
                    </div>
                    <div id="teemonunPasifi" class="labelInput" style="display:none;">
                        <p style="margin: 0; padding: 0; color: red;">Teemo burada gizleniyor</p>
                    </div>
                    <div class="labelInput" style="margin-top: 10px;">
                        <input id="submitBtn" type="submit" value="Anmeldung" >
                    </div>
                    <div class="labelInput" style="margin-top: 20px;">
                        <span id="createAccountSpan" style="display: block; font-weight: normal; margin-bottom: 8px; font-size: 1.05rem;">Sie haben kein Konto?</span>
                        <button type="button" id="popUpPanelButton">Registrieren</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="registerForm" method="POST">
                <div class="header">
                    <div class="first_two_one">
                        <h1 style="margin: 0; margin-top: 5px; padding: 0;">
                            <!-- Register Form -->
                            Anmeldeformular
                        </h1>
                        <p style="margin:0; padding:0;">
                            Erstellen Sie Ihr Konto und füllen Sie Ihre Tasche.
                        </p>
                    </div>
                    <div class="first_two_two">
                        <span class="close">&times;</span>
                    </div>
                    <div class="clear"></div>
                </div>
                <hr style="margin:0; padding:0;">
                <div id="teemoPassiveDiv">
                    <p id="teemoPassive" style="text-align:center; margin:0; padding:0;">
                        <!-- Please fill in the empty inputs -->
                        Bitte füllen Sie die leeren Eingaben aus
                    </p>
                </div>
                <div class="bodyForInputs" style="margin-top: 5px">
                    <div class="first_two_input">
                        <input id="modal_name" name="name" minlength="3" required="required" class="first_two_input_input" style="float:left;" type="text" placeholder="Name"/>
                        <input id="modal_lastname" name="lastname" minlength="2" required="required" class="first_two_input_input" style="float:right;" type="text" placeholder="Nachname"/>
                        <div class="clear"></div>
                    </div>
                    <div class="emailpass">
                        <input id="modal_email" name="modal_email" required="required" style="width: 100%;" type="email" placeholder="E-Mail" pattern="^[^\s]+.*[^\s]+$">
                        <input id="modal_password" name="modal_password" minlength="5" required="required" type="password" placeholder="Passwort" style="width: 100%; margin-top: 10px;">
                        <input id="telnumber" name="telnumber" pattern="[0-9.]+" minlength="5" required="required" type="tel" placeholder="Telefonnummer:Nur Zahlen" style="width: 100%; margin-top: 10px;">
                        <input id="nationalorpassport" name="nationalorpassport" minlength="5" required="required" type="text" placeholder="Personalausweis oder Reisepass" style="width: 100%; margin-top: 10px;">
                    </div>
                    <div class="birthDateCollect">
                        <!-- <span>Date Of Birth</span> -->
                        <span>Geburtsdatum</span>
                        <div class="birthDateDiv">
                            <select name="days" id="days" required="required">
                                <option disabled selected value>Tag</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                            </select>
                            <select name="months" id="months" required="required">
                                <option disabled selected value>Monat</option>    
                                <option value="1">Januar</option>
                                <option value="2">Februar</option>
                                <option value="3">März</option>
                                <option value="4">April</option>
                                <option value="5">Mai</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Dezember</option>
                            </select>
                            <select name="years" id="years" required="required">
                                <option disabled selected value>Jahr</option>
                                <option value="2004">2004</option>
                                <option value="2003">2003</option>
                                <option value="2002">2002</option>
                                <option value="2001">2001</option>
                                <option value="2000">2000</option>
                                <option value="1999">1999</option>
                                <option value="1998">1998</option>
                                <option value="1997">1997</option>
                                <option value="1996">1996</option>
                                <option value="1995">1995</option>
                                <option value="1994">1994</option>
                                <option value="1993">1993</option>
                                <option value="1992">1992</option>
                                <option value="1991">1991</option>
                                <option value="1990">1990</option>
                                <option value="1989">1989</option>
                                <option value="1988">1988</option>
                                <option value="1987">1987</option>
                                <option value="1986">1986</option>
                                <option value="1985">1985</option>
                                <option value="1984">1984</option>
                                <option value="1983">1983</option>
                                <option value="1982">1982</option>
                                <option value="1981">1981</option>
                                <option value="1980">1980</option>
                                <option value="1979">1979</option>
                                <option value="1978">1978</option>
                                <option value="1977">1977</option>
                                <option value="1976">1976</option>
                                <option value="1975">1975</option>
                                <option value="1974">1974</option>
                                <option value="1973">1973</option>
                                <option value="1972">1972</option>
                                <option value="1971">1971</option>
                                <option value="1970">1970</option>
                                <option value="1969">1969</option>
                                <option value="1968">1968</option>
                                <option value="1967">1967</option>
                                <option value="1966">1966</option>
                                <option value="1965">1965</option>
                                <option value="1964">1964</option>
                                <option value="1963">1963</option>
                                <option value="1962">1962</option>
                                <option value="1961">1961</option>
                                <option value="1960">1960</option>
                                <option value="1959">1959</option>
                                <option value="1958">1958</option>
                                <option value="1957">1957</option>
                                <option value="1956">1956</option>
                                <option value="1955">1955</option>
                                <option value="1954">1954</option>
                                <option value="1953">1953</option>
                                <option value="1952">1952</option>
                                <option value="1951">1951</option>
                                <option value="1950">1950</option>
                                <option value="1949">1949</option>
                                <option value="1948">1948</option>
                                <option value="1947">1947</option>
                                <option value="1946">1946</option>
                                <option value="1945">1945</option>
                                <option value="1944">1944</option>
                                <option value="1943">1943</option>
                                <option value="1942">1942</option>
                                <option value="1941">1941</option>
                                <option value="1940">1940</option>
                                <option value="1939">1939</option>
                                <option value="1938">1938</option>
                                <option value="1937">1937</option>
                                <option value="1936">1936</option>
                                <option value="1935">1935</option>
                                <option value="1934">1934</option>
                                <option value="1933">1933</option>
                                <option value="1932">1932</option>
                                <option value="1931">1931</option>
                                <option value="1930">1930</option>
                                <option value="1929">1929</option>
                                <option value="1928">1928</option>
                                <option value="1927">1927</option>
                                <option value="1926">1926</option>
                                <option value="1925">1925</option>
                                <option value="1924">1924</option>
                                <option value="1923">1923</option>
                                <option value="1922">1922</option>
                                <option value="1921">1921</option>
                                <option value="1920">1920</option>
                                <option value="1919">1919</option>
                                <option value="1918">1918</option>
                                <option value="1917">1917</option>
                                <option value="1916">1916</option>
                                <option value="1915">1915</option>
                                <option value="1914">1914</option>
                                <option value="1913">1913</option>
                                <option value="1912">1912</option>
                                <option value="1911">1911</option>
                                <option value="1910">1910</option>
                                <option value="1909">1909</option>
                                <option value="1908">1908</option>
                                <option value="1907">1907</option>
                                <option value="1906">1906</option>
                                <option value="1905">1905</option>
                                <option value="1904">1904</option>
                                <option value="1903">1903</option>
                                <option value="1902">1902</option>
                                <option value="1901">1901</option>
                                <option value="1900">1900</option>
                            </select>
                        </div>
                    </div>
                    <div class="genderCollector">
                        <div>
                            <!-- <span>Gender</span> -->
                            <span>Geschlecht</span>
                        </div>
                        <div class="genderDiv">
                            <div class="boxForGenders">
                                <label for="erkek"><span>Männlich</span></label>
                                <div class="radioInput">
                                    <input type="radio" id="man" name="gender" value="man" required="required">
                                </div>
                            </div>
                            <div class="boxForGenders">
                                <label for="kadın"><span>Frau</span></label>
                                <div class="radioInput">
                                    <input type="radio" id="woman" name="gender" value="woman"  required="required">
                                </div>
                            </div>
                            <div class="boxForGenders">
                                <label for="ozel"><span>Besondere</span></label>
                                <div class="radioInput">
                                    <input type="radio" id="private" name="gender" value="private"  required="required">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="margin-bottom: 0px; padding-bottom: 0px;">
                <div class="endOfContent">
                    <div style="text-align: center; margin-top: 10px;">
                        <button type="submit" id="registerButton">Registrieren</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
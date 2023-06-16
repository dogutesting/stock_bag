<?php
error_reporting(0);
session_start();
if (!is_null($_SESSION['logged_in'])) {
    echo "1";
}
else {
    echo "0";
}

?>
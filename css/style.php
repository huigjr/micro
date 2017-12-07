<?php
session_start();
include '../config/config.php';
//$seconds_to_cache = 1209600; // = 2 weeks (for google pagespeed)
$seconds_to_cache = 10;
$ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
header("Expires: $ts");
header("Content-type: text/css");
$templatedir = defined(TEMPLATE) ? TEMPLATE : 'default';
include("../template/$templatedir/css/style.css");
?>

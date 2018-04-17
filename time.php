<?php

//var_dump(setlocale(LC_ALL, 'Chinese'));

echo setlocale (LC_TIME, "dut");
//echo strftime("%A %d %B %Y", time()).'<br>';

echo '<br>';

echo setlocale (LC_TIME, "fin");
//echo strftime("%A %d %B %Y", time()).'<br>';

echo '<br>';

echo setlocale (LC_TIME, "Dutch");
//echo strftime("%A %d %B %Y", time()).'<br>';

echo '<br>';

echo setlocale (LC_TIME, "Finnish");
//echo strftime("%A %d %B %Y", time()).'<br>';

echo '<br>';

echo setlocale (LC_TIME, 'ru_RU.UTF-8', 'Rus');
$rus = strftime("%A %d %B %Y", time()).'<br>';
//echo mb_convert_encoding($rus, "utf-8", "windows-1251");

echo '<br>';

echo setlocale (LC_TIME, "Chinese");
$chi = strftime("%A %d %B %Y", time()).'<br>';
//echo mb_convert_encoding($chi, "utf-8", "CP936");

echo '<br>';

echo setlocale (LC_TIME, "Vietnamese");
$vie = strftime("%A %d %B %Y", time()).'<br>';
echo @mb_convert_encoding($vie, "utf-8", "WINDOWS-1258").'<br>';
echo iconv("WINDOWS-1258","UTF-8",$vie);

include 'src/FluxCapacitor.php';
$time = new FluxCapacitor();

echo $time->getCarnaval(2020);
?>

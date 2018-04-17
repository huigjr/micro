<?php
// PHP configuration settings
error_reporting(E_ALL);
ini_set('display_errors', '1'); // set to 0 in production

// Load config
include 'config/config.php';

// Autoload classes (includes not needed)
spl_autoload_register(function($class){ include ROOT.'/src/'.$class.'.php'; });

$xml = new XmlBuilder(1);

$array = array(
  'name' => 'Huig',
  'function' => 'Developer',
  'tools' => array(
    'computer' => 'laptop',
    'phone' => 'mobile'),
  'food' => 'apple',
);

//header( "content-type: application/xml; charset=utf-8" );
//header( "content-type: text/plain; charset=utf-8" );
//header( "content-type: text/plain; charset=ISO-8859-1" );

//echo $xml->arrayToXml($array);

echo sha1(time(),true);

//$string = 'Są pewni ludzie, zwłaszcza członkowie rodziny, których od czasu do czasu widzisz lub inni bliscy krewni, którzy po prostu nie wiedzą, gdzie należy się zatrzymać, kiedy coś ofiarujesz. Zazwyczaj chodzi o picie alkoholu, jedzenie ciast i inne rzeczy, które muszę zrobić, ponieważ wszyscy inni też to robią.';

//$string = utf8_decode($string);

//setlocale(LC_CTYPE, 'Polish');
//$string = iconv("UTF-8", "ISO-8859-2//IGNORE", $string);

//$list = array('UTF-8','ISO-8859-1','Windows-1252');
//echo mb_detect_encoding($string,mb_list_encodings());
//echo utf8_decode($string);

//var_dump(mb_list_encodings());

//var_dump(mb_detect_order());

//echo 'DONE';
?>
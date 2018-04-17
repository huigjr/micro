<?php
// PHP configuration settings
error_reporting(E_ALL);
ini_set('display_errors', '1'); // set to 0 in production

// Start timer
$starttime = microtime(true);

// Load config
include 'config/config.php';

// Autoload classes (includes not needed)
spl_autoload_register(function($class){ include ROOT.'/src/'.$class.'.php'; });

// Resolve path and fetch page requirements
$di = new DI();
$page = $di->get('Controller');

// Start template engine and load template file
$view = new Template(ROOT.'/template/default/'.$page->template);

// Transfer all page properties to template
foreach(get_object_vars($page) as $key => $value) $view->$key = $value;

$view->executiontime = (round((microtime(true) - $starttime) * 1000000) / 1000).'ms';

// Publish template to browser
echo $view;
?>
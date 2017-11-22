<?php
// PHP configuration settings
error_reporting(E_ALL);
ini_set('display_errors', '1'); // set to 0 in production

// Measure execution time
$starttime = microtime(true);

// Enable session variables
session_start();

// Include configuration settings
include 'config/config.php';

// Autoload classes (includes not needed)
spl_autoload_register(function($class){include ROOT_DIR.'/classes/'.strtolower($class).'.class.php';});

// Setup DB connection
$db = new Connection(DB_HOST,DB_NAME,DB_USER,DB_PASS);

// Resolve path and fetch page requirements
$page = new Controller($db);

// Start template engine and load template file
$view = new Template('template/default/'.$page->template);

// Transfer all page properties to template
foreach(get_object_vars($page) as $key => $value) $view->$key = $value;

$view->executiontime = (round((microtime(true) - $starttime) * 100000) / 100).' ms';

// Publish template to browser
echo $view;
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

include 'config/config.php';

if(isset($_POST['login'])){
  $_SESSION['userlevel'] = 1;
  header('location: /'.ADMIN_DIR.'/dashboard/');
}
?>
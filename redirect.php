<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

if(isset($_POST['login'])){
  $_SESSION['logedin'] = true;
  header('location: /admin/dashboard.php');
}
?>
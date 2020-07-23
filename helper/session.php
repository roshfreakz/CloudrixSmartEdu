<?php
require_once('config.php');
session_start();

if(!isset($_SESSION['UserId'])){
    header("location: login.php");
    die();
}

?>
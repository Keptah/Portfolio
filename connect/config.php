<?php
 $db_user = "root";
 $db_password = "";
 $db_name = "weather_v5";
 $db_port = "3307";
 $db_host = "localhost";
try {
    $db = new PDO('mysql:host=' .$db_host. ';port=' . $db_port . ';dbname=' . $db_name, $db_user, $db_password);
    $db->exec('set names utf8 COLLATE utf8mb3_czech_ci');
  }catch (Exception $e) {
    error_log($e->getMessage());
    exit('PDO conection error'); 
  }
?>

<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Samet7878');
define('DB_NAME', 'kirtasiyeveritabani');
 
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    die("HATA: 'Baglanti kurulamadi.' " . mysqli_connect_error());
    echo "SQL Baglanti hatasi";
}
?>
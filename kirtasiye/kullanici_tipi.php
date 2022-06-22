<?php

session_start();

if (@$_SESSION["giris"] && $_SESSION["giris"] == true) {
    $kullanici_tipi = ($_SESSION["tip"] == "Kirtasiye") ? "Kirtasiye" : "Musteri";
} else {
    $kullanici_tipi = "Ziyaretci";
}

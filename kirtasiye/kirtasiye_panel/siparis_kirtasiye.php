<?php

require_once "../config.php";
require_once "../kullanici_tipi.php";

if ($kullanici_tipi != "Kirtasiye") {
    echo "<script>alert('Hata: Bu sayfaya erişebilmek için Kırtasiye hesabınızla giriş yapmalısınız.'); window.location = '../index.php';</script>";
    exit;
}

if (isset($_SESSION["giris"]) && $_SESSION["giris"] === true) {
    $hesap_id = $_SESSION["hesap_id"];

    $query = "SELECT *, CONCAT(musteri.ad, ' ', musteri.soyad) AS musteri_ad_soyad, musteri.adres AS musteri_adres, musteri.telefon AS musteri_telefon FROM urun_musteri INNER JOIN urun ON urun.urun_id = urun_musteri.urun_id INNER JOIN musteri ON musteri.musteri_id = urun_musteri.musteri_id INNER JOIN kirtasiye ON kirtasiye.kirtasiye_id = urun.kirtasiye_id ORDER BY id DESC";
    $result = mysqli_query($link, $query);
}

mysqli_close($link);
?>

<!doctype html>
<html lang="tr">

<head>
    <title>Siparişler</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body style="background-color: #FCFCFC">
    <?php require_once "../navbar.php"; ?>
    <br>
    <div class="container" style="background-color: #FFF; border:1px solid #000">
        <div class="row">
            <div class="col-12">
                <br>
                <h1 style="color: #0069D9">Siparişler</h1>
                <br>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"># Sipariş No</th>
                            <th scope="col">Ürün Adı</th>
                            <th scope="col">Marka</th>
                            <th scope="col">Renk</th>
                            <th scope="col">Alıcı</th>
                            <th scope="col">Adres</th>
                            <th scope="col">Telefon</th>
                            <th scope="col">Fiyat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($rows = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <th><?php echo $rows["id"] ?></th>
                                <td><?php echo $rows["urun_adi"] ?></td>
                                <td><?php echo $rows["marka"] ?></td>
                                <td><?php echo $rows["renk"] ?></td>
                                <td><?php echo $rows["musteri_ad_soyad"] ?></td>
                                <td><?php echo $rows["musteri_adres"] ?></td>
                                <td><?php echo $rows["musteri_telefon"] ?></td>
                                <td><?php echo $rows["fiyat"] ?> ₺</td>
                            </tr>
                        <?php
                        }
                        mysqli_free_result($result);
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    <footer id="sticky-footer" class="flex-shrink-0 py-4 bg-dark text-white-50">
        <div class="container text-center">
            <small>Copyright &copy; Samet Özkan</small>
        </div>
    </footer>
</body>

</html>
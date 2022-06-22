<?php

require_once "config.php";
require_once "kullanici_tipi.php";

if (@$_GET["urun_id"]) {
    $_SESSION["urun_id"] = $_GET["urun_id"];
    $urun_id = $_SESSION["urun_id"];
} else {
    if (@$_SESSION["urun_id"]) {
        $urun_id = $_SESSION["urun_id"];
    } else {
        header("Location: index.php");
    }
}


$query = "SELECT * FROM urun INNER JOIN kategori ON urun.kategori_id = kategori.kategori_id INNER JOIN kirtasiye ON kirtasiye.kirtasiye_id = urun.kirtasiye_id WHERE urun.urun_id = $urun_id";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if ($kullanici_tipi == "Musteri") {
        $hesap_id = $_SESSION["hesap_id"];
        $sql_urun_musteri = "INSERT INTO urun_musteri(urun_id, musteri_id) VALUES ((SELECT urun_id FROM urun WHERE urun_id = $urun_id), (SELECT musteri_id FROM musteri WHERE hesap_id = $hesap_id))";
        $stmt_urun_musteri = mysqli_prepare($link, $sql_urun_musteri);
        if (!mysqli_stmt_execute($stmt_urun_musteri)) {
            echo "<script>alert('Hata: Sipariş verebilmek için \"Bilgilerim\" sayfasına bilgilerinizi eklemelisiniz.'); window.location = 'index.php';</script>";
        } else {
            echo "<script>alert('Başarılı: Sipariş verildi.'); window.location = 'urun.php?urun_id=$urun_id';</script>";
        }
        mysqli_stmt_close($stmt_urun_musteri);
    } else {
        echo "<script>alert('Hata: Sipariş verebilmek için Müşteri hesabınızla giriş yapmalısınız.'); window.location = 'urun.php?urun_id=$urun_id';</script>";
    }
}

?>

<!doctype html>
<html lang="tr">

<head>
    <title>Ürün</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body style="background-color: #FCFCFC">
    <?php require_once dirname(__DIR__) . "/kirtasiye/navbar.php"; ?>

    <br>
    <div class="container">
        <div class="row" style="background-color: #FFF; border:1px solid #000">
            <div class="col-12">
                <br>
                <h1 style="color: #0069D9">Satın Al</h1>
                <br>
                <div class="thumbnail">
                    <div class="caption">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h3 class="card-title" style="color: #0069D9"><?php echo $row["urun_adi"] ?></h3>
                            </li>
                            <li class="list-group-item"><b>Satıcı:</b> <?php echo $row["kirtasiye_adi"] ?></li>
                            <li class="list-group-item"><b>Marka:</b> <?php echo $row["marka"] ?></li>
                            <li class="list-group-item"><b>Kategori:</b> <?php echo $row["kategori_adi"] ?></li>
                            <li class="list-group-item"><b>Renk:</b> <?php echo $row["renk"] ?></li>
                            <li class="list-group-item"><b>Stok:</b> <?php echo $row["stok"] ?> adet</li>
                            <li>
                                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" id="siparis_ver" name="siparis_ver">Satın Al: <?php echo $row["fiyat"] ?> ₺</button>
                                </form>
                            </li>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <br>
    </div>
    <footer id="sticky-footer" class="flex-shrink-0 py-4 bg-dark text-white-50">
        <div class="container text-center">
            <small>Copyright &copy; Samet Özkan</small>
        </div>
    </footer>
</body>

</html>
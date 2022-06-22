<?php
require_once "../config.php";
require_once "../kullanici_tipi.php";

if ($kullanici_tipi != "Kirtasiye") {
    echo "<script>alert('Hata: Bu sayfaya erişebilmek için Kırtasiye hesabınızla giriş yapmalısınız.'); window.location = '../index.php';</script>";
}

if (isset($_SESSION["giris"]) && $_SESSION["giris"] === true) {
    $kirtasiye_sahibi = $_SESSION["hesap_id"];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $sql = "INSERT INTO kategori(kategori_adi, aciklama, kirtasiye_id) VALUES(?, ?, (SELECT kirtasiye_id FROM kirtasiye WHERE kirtasiye_sahibi = ?))";
        $stmt = mysqli_prepare($link, $sql);
        $kategori_adi = $_POST["kategori_adi"];
        $aciklama = $_POST["aciklama"];
        mysqli_stmt_bind_param($stmt, "ssi", $kategori_adi, $aciklama, $kirtasiye_sahibi);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>window.alert('Başarılı: Kategori eklendi.')</script>";
        } else {
            echo "<script>window.alert('Hata: Kategori eklenemedi.')</script>";
            echo "<script>window.alert('Dikkat: \"Kırtasiye Bilgileri\" sayfasındaki formu doldurmadan kategori eklenemez.')</script>";
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($link);
?>

<!doctype html>
<html lang="tr">

<head>
    <title>Kategori Ekle</title>
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
                <h1 style="color: #0069D9">Kategori Ekle</h1>
                <br>
                <div class="alert alert-warning" role="alert">
                    * Tüm alanların doldurulması zorunludur.
                </div>
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
                            </svg> <b>Kategori Adı:</b></label>
                        <input type="text" class="form-control" id="kategori_adi" name="kategori_adi" placeholder="Kategori adı giriniz." value="<?php echo @$kirtasiye_adi ?>">
                    </div>
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
                            </svg> <b>Açıklama:</b></label>
                        <input type="text" class="form-control" id="aciklama" name="aciklama" placeholder="Aciklama giriniz." value="<?php echo @$adres ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Ekle</button>
                </form>
                <br>
            </div>
        </div>
    </div>
    <footer id="sticky-footer" class="flex-shrink-0 py-4 bg-dark text-white-50">
        <div class="container text-center">
            <small>Copyright &copy; Samet Özkan</small>
        </div>
    </footer>
</body>

</html>
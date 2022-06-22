<?php

require_once "../config.php";
require_once "../kullanici_tipi.php";

if ($kullanici_tipi != "Musteri") {
    echo "<script>alert('Hata: Bu sayfaya erişebilmek için Müşteri hesabınızla giriş yapmalısınız.'); window.location = '../index.php';</script>";
    mysqli_close($link);
    exit;
}

if (isset($_SESSION["giris"]) && $_SESSION["giris"] === true) {
    $hesap_id = $_SESSION["hesap_id"];
    $stmt = mysqli_prepare($link, "SELECT ad, soyad, dogum_yeri, uyruk, dogum_tarihi, adres, telefon, email FROM musteri WHERE hesap_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $hesap_id);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            //Müşteri bulundu.
            if (mysqli_stmt_num_rows($stmt) == 1) {
                $sql_post = "UPDATE musteri SET ad = ?, soyad = ?, dogum_yeri = ?, uyruk = ?, dogum_tarihi = ?, adres = ? , telefon = ?, email = ? WHERE hesap_id = ?";
                $stmt_post = mysqli_prepare($link, $sql_post);
                mysqli_stmt_bind_param($stmt_post, "ssssssssi", $ad_post, $soyad_post, $dogum_yeri_post, $uyruk_post, $dogum_tarihi_post, $adres_post, $telefon_post, $email_post, $hesap_id);
                mysqli_stmt_bind_result($stmt, $ad, $soyad, $dogum_yeri, $uyruk, $dogum_tarihi, $adres, $telefon, $email);
                if (mysqli_stmt_fetch($stmt)) {
                }
            } else {
                $sql_post = "INSERT INTO musteri(ad, soyad, dogum_yeri, uyruk, dogum_tarihi, adres, telefon, email, hesap_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt_post = mysqli_prepare($link, $sql_post);
                mysqli_stmt_bind_param($stmt_post, "ssssssssi", $ad_post, $soyad_post, $dogum_yeri_post, $uyruk_post, $dogum_tarihi_post, $adres_post, $telefon_post, $email_post, $hesap_id);
            }
        }
    }
    mysqli_stmt_close($stmt);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $ad_post = $_POST["ad"];
        $soyad_post = $_POST["soyad"];
        $dogum_yeri_post = $_POST["dogum_yeri"];
        $uyruk_post = $_POST["uyruk"];
        $dogum_tarihi_post = $_POST["dogum_tarihi"];
        $adres_post = $_POST["adres"];
        $telefon_post = $_POST["telefon"];
        $email_post = $_POST["email"];
        if (mysqli_stmt_execute($stmt_post)) {
            echo "<script>window.alert('Başarılı: Bilgiler eklendi.')</script>";
        } else {
            echo "<script>window.alert('Hata: Bilgiler eklenemedi. Tüm alanları doldurduğunuzdan emin olunuz.')</script>";
        }
        mysqli_stmt_close($stmt_post);
        mysqli_close($link);
        header("Refresh:0");
    }
}


?>

<!doctype html>
<html lang="tr">

<head>
    <title>Bilgilerim</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body style="background-color: #FCFCFC">
    <?php require_once dirname(__DIR__) . "/navbar.php"; ?>

    <br>
    <div class="container" style="background-color: #FFF; border:1px solid #000">
        <div class="row">
            <div class="col-12">
                <br>
                <h1 style="color: #0069D9">Bilgilerim</h1>
                <br>
                <div class="alert alert-warning" role="alert">
                    * Tüm alanların doldurulması zorunludur.
                </div>
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                </svg> <b>Ad:</b></label>
                            <input type="text" class="form-control" id="ad" name="ad" placeholder="Adınızı giriniz." value="<?php echo @$ad ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                </svg> <b>Soyad:</b></label>
                            <input type="text" class="form-control" id="soyad" name="soyad" placeholder="Soyadınızı giriniz." value="<?php echo @$soyad ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                            </svg> <b>Adres:</b></label>
                        <input type="text" class="form-control" id="adres" name="adres" placeholder="Adres giriniz." value="<?php echo @$adres ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                </svg> <b>Email:</b></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email giriniz." value="<?php echo @$email ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                </svg> <b>Telefon:</b></label>
                            <input type="tel" class="form-control" id="telefon" name="telefon" placeholder="Telefon giriniz." value="<?php echo @$telefon ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                </svg> <b>Uyruk:</b></label>
                            <input type="text" class="form-control" id="uyruk" name="uyruk" placeholder="Uyruk giriniz." value="<?php echo @$uyruk ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                </svg> <b>Doğum Yeri:</b></label>
                            <input type="text" class="form-control" id="dogum_yeri" name="dogum_yeri" placeholder="Doğum yeri giriniz." value="<?php echo @$dogum_yeri ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                            </svg> <b>Doğum Tarihi:</b></label>
                        <input type="date" class="form-control" id="dogum_tarihi" name="dogum_tarihi" value="<?php echo @$dogum_tarihi ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
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
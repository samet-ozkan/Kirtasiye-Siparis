<?php

require_once "config.php";
require_once "kullanici_tipi.php";

if ($kullanici_tipi != "Ziyaretci") {
    echo "<script>alert('Hata: Bu sayfaya erişebilmek için Ziyaretçi olmalısınız.'); window.location = '../index.php';</script>";
    exit;
}

$kullanici_adi = "";
$sifre = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $form_hata = (empty(trim($_POST["kullanici_adi"]))) ? ("Kullanici adi girin.") : (((empty(trim($_POST["sifre"])))) ? ("Sifre girin.") : (""));

    if ($form_hata == "") {
        $kullanici_adi = $_POST["kullanici_adi"];
        $sifre = $_POST["sifre"];
        $stmt = mysqli_prepare($link, "SELECT hesap.hesap_id, hesap.kullanici_adi, hesap.sifre, tip.tip FROM hesap INNER JOIN tip ON hesap.tip_id = tip.tip_id WHERE kullanici_adi = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $kullanici_adi);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $hesap_id, $kullanici_adi, $sifreHash, $tip);
                    if (mysqli_stmt_fetch($stmt)) {
                        $sifre_hata = password_verify($sifre, $sifreHash) ? "" : "Hatali kullanici adi veya sifre";
                        if ($sifre_hata == "") {
                            $_SESSION["giris"] = true;
                            $_SESSION["hesap_id"] = $hesap_id;
                            $_SESSION["kullanici_adi"] = $kullanici_adi;
                            $_SESSION["tip"] = $tip;
                            echo "<script>alert('Başarılı: Giriş yapıldı. ($tip)'); window.location = 'index.php';</script>";
                        } else {
                            echo "<script>window.alert('Hata: $sifre_hata')</script>";
                        }
                    }
                } else {
                    echo "<script>window.alert('Hata: Kullanıcı bulunamadı.')</script>";
                }
            } else {
                echo "<script>window.alert('Hata: Sorgu çalıştırılamadı.')</script>";
            }

            mysqli_stmt_close($stmt);
        }
    } else {
        echo "<script>window.alert('Hata: $form_hata')</script>";
    }

    mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body style="background-color: #FCFCFC">
    <?php require_once dirname(__DIR__) . "/kirtasiye/navbar.php"; ?>

    <br>
    <div class="container" style="background-color: #FFF; border:1px solid #000">
        <div class="row">
            <div class="col-12">
                <br>
                <h1 style="color: #0069D9">Giriş Yap</h1>
                <br>
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                            </svg> <b>Kullanıcı Adı:</b></label>
                        <input type="text" class="form-control" id="kullanici_adi" name="kullanici_adi" placeholder="Kullanıcı adı giriniz.">
                    </div>
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                            </svg> <b>Şifre:</b></label>
                        <input type="password" class="form-control" id="sifre" name="sifre" placeholder="Şifre giriniz.">
                    </div>
                    <button type="submit" class="btn btn-primary">Giriş Yap</button>
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
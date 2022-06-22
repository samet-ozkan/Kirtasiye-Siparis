<?php

require_once "config.php";
require_once "kullanici_tipi.php";

if ($kullanici_tipi != "Ziyaretci") {
    echo "<script>alert('Hata: Bu sayfaya erişebilmek için Ziyaretçi olmalısınız.'); window.location = '../index.php';</script>";
    exit;
}

$kullanici_adi = "";
$sifre = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Kullanici adi kontrol
    if (!empty(trim($_POST["kullanici_adi"]))) {
        $stmt = mysqli_prepare($link, "SELECT hesap_id
        FROM hesap WHERE kullanici_adi = ?");
        if ($stmt) {
            $param = trim($_POST["kullanici_adi"]);
            mysqli_stmt_bind_param($stmt, "s", $param);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 0) {
                    $kullanici_adi = trim($_POST["kullanici_adi"]);
                } else {
                    echo "<script>window.alert('Hata: Kullanıcı adı mevcut.')</script>";
                }
            } else {
                echo "<script>window.alert('Hata!')</script>";
            }
        } else {
            echo "<script>window.alert('Hata!')</script>";
        }

        mysqli_stmt_close($stmt);
    }

    $hataMesaji = ((((empty(trim($_POST["sifre"]))) ? ("Şifre boş olamaz") : (empty(trim($_POST["sifre_tekrar"])))) ? ("Şifre tekrar boş olamaz.") : (strlen(trim($_POST["sifre"])) < 6)) ? ("Şifre uzunluğu minimum 6 karakter olmalıdır.") : (trim($_POST["sifre"]) != trim($_POST["sifre_tekrar"]))) ? ("Şifre ile şifre tekrar uyuşmuyor.") : ("");

    if (empty($hataMesaji)) {
        $sifre = trim($_POST["sifre"]);
    } else {
        echo "<script>window.alert('$hataMesaji')</script>";
    }

    if (!empty($kullanici_adi) && !empty($sifre)) {
        $tip = $_POST["hesap_tipi"];
        $query = "SELECT * FROM tip WHERE tip = '$tip';";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);
        $insert_tip = $row["tip_id"];
        $stmt2 = mysqli_prepare($link, "INSERT INTO hesap(kullanici_adi, sifre, tip_id)
        VALUES (?, ?, $insert_tip);");
        if ($stmt2) {
            $sifreHash = password_hash($sifre, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt2, "ss", $kullanici_adi, $sifreHash);
            if (mysqli_stmt_execute($stmt2)) {
                echo "<script>window.alert('Başarılı: Kayıt olundu.')</script>";
            } else {
                echo "<script>window.alert('Hata: Kayıt olunamadı.')</script>";
            }
        }

        mysqli_free_result($result);
        mysqli_stmt_close($stmt2);
    }

    mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body style="background-color: #FCFCFC">
    <?php require_once dirname(__DIR__) . "/kirtasiye/navbar.php"; ?>

    <br>
    <div class="container" style="background-color: #FFF; border:1px solid #000">
        <div class="row">
            <div class="col-12">
                <br>
                <h1 style="color: #0069D9">Kayıt Ol</h1>
                <br>
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                            </svg> <b>Kullanıcı Adı:</b></label>
                        <input type="text" class="form-control" id="kullanici_adi" name="kullanici_adi" placeholder="Kullanıcı adı giriniz.">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                </svg> <b>Şifre:</b></label>
                            <input type="password" class="form-control" id="sifre" name="sifre" placeholder="Şifre giriniz.">
                        </div>
                        <div class="form-group col-md-6">
                            <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                </svg> <b>Şifre Tekrar:</b></label>
                            <input type="password" class="form-control" id="sifre_tekrar" name="sifre_tekrar" placeholder="Şifrenizi tekrar giriniz." value="<?php echo @$telefon ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                            </svg> <b>Hesap Tipi:</b></label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hesap_tipi" id="kirtasiye" value="Kirtasiye">
                            <label class="form-check-label" for="inlineRadio1">Kırtasiye</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hesap_tipi" id="musteri" value="Musteri">
                            <label class="form-check-label" for="inlineRadio2">Müşteri</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Kayıt Ol</button>
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
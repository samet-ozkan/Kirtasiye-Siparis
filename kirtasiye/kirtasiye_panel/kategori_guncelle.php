<?php
require_once "../config.php";
require_once "../kullanici_tipi.php";

if ($kullanici_tipi != "Kirtasiye") {
    echo "<script>alert('Hata: Bu sayfaya erişebilmek için Kırtasiye hesabınızla giriş yapmalısınız.'); window.location = '../index.php';</script>";
    exit;
}

if (isset($_SESSION["giris"]) && $_SESSION["giris"] === true) {
    $kirtasiye_sahibi = $_SESSION["hesap_id"];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if ($_POST["islem"] == "Sil") {
            $sql_kategori_sil = "DELETE FROM kategori WHERE kategori_id = ?";
            $stmt_kategori_sil = mysqli_prepare($link, $sql_kategori_sil);
            if ($stmt_kategori_sil) {
                mysqli_stmt_bind_param($stmt_kategori_sil, "i", $_POST["kategori_id"]);
                if (mysqli_stmt_execute($stmt_kategori_sil)) {
                    echo "<script>window.alert('Başarılı: Kategori silindi.')</script>";
                } else {
                    echo "<script>window.alert('Hata: Kategori silinemedi.')</script>";
                }
                mysqli_stmt_close($stmt_kategori_sil);
            }
        } else {
            if (@$_POST["kategori_id"]) {
                $sql_kategori_duzenle = "UPDATE kategori SET kategori_adi = ?, aciklama = ? WHERE kategori_id = ?";
                $stmt_kategori_duzenle = mysqli_prepare($link, $sql_kategori_duzenle);
                if ($stmt_kategori_duzenle) {
                    mysqli_stmt_bind_param($stmt_kategori_duzenle, "ssi", $_POST["kategori_adi"], $_POST["aciklama"], $_POST["kategori_id"]);
                    if (mysqli_stmt_execute($stmt_kategori_duzenle)) {
                        echo "<script>window.alert('Başarılı: Kategori güncellendi..')</script>";
                    } else {
                        echo "<script>window.alert('Hata: Kategori güncellenemedi. Tüm alanları doldurduğunuzdan emin olunuz.')</script>";
                    }
                    mysqli_stmt_close($stmt_kategori_duzenle);
                    header("Refresh:0");
                }
            }
        }
        mysqli_close($link);
    }
}

?>

<!doctype html>
<html lang="tr">

<head>
    <title>Kategori Güncelle</title>
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
                <h1 style="color: #0069D9">Kategori Güncelle</h1>
                <br>
                <div class="alert alert-warning" role="alert">
                    * Tüm alanların doldurulması zorunludur.
                </div>
                <select class="form-control" id="kategori_listesi" onchange="formDoldur(value);">
                    <option value="0">Lütfen kategori seçin:</option>
                    <?php
                    $sql_kirtasiye = "SELECT kirtasiye_id FROM kirtasiye WHERE kirtasiye_sahibi = ?";
                    $stmt_kirtasiye = mysqli_prepare($link, $sql_kirtasiye);
                    mysqli_stmt_bind_param($stmt_kirtasiye, "i", $kirtasiye_sahibi);
                    mysqli_stmt_execute($stmt_kirtasiye);
                    mysqli_stmt_store_result($stmt_kirtasiye);
                    mysqli_stmt_bind_result($stmt_kirtasiye, $kirtasiye_id);
                    mysqli_stmt_fetch($stmt_kirtasiye);

                    $query = "SELECT * FROM kategori WHERE kirtasiye_id = $kirtasiye_id";
                    $result = mysqli_query($link, $query);
                    while ($rows = mysqli_fetch_assoc($result)) {
                    ?>
                        <script>
                            var kategori = document.createElement("option");
                            kategori.value = "<?php echo $rows["kategori_id"] ?>/<?php echo $rows["kategori_adi"] ?>/<?php echo $rows["aciklama"] ?>";
                            kategori.innerHTML = "<?php echo $rows["kategori_adi"] ?>";
                            document.getElementById("kategori_listesi").appendChild(kategori);
                        </script>
                    <?php
                    }

                    mysqli_free_result($result);
                    ?>
                </select>
                <br>
                <form id="form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
                            </svg> <b>Kategori Adı:</b></label>
                        <input type="text" class="form-control" id="kategori_adi" name="kategori_adi" placeholder="Kategori adı giriniz." value="">
                    </div>
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
                            </svg> <b>Açıklama</b></label>
                        <input type="text" class="form-control" id="aciklama" name="aciklama" placeholder="Açıklama giriniz." value="">
                    </div>
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
                            </svg> <b>Kategori ID:</b></label>
                        <input class="form-control" type="text" id="kategori_id" name="kategori_id" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary" name="islem" value="Kaydet">Kaydet</button>
                    <button type="submit" class="btn btn-danger" name="islem" value="Sil">Kategoriyi Sil</button>
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
<script>
    document.getElementById("form").style.visibility = "hidden";

    function formDoldur(liste) {
        if (liste == 0) {
            document.getElementById("form").style.visibility = "hidden";
        } else {
            document.getElementById("form").style.visibility = "visible";
        }
        kategori_bilgileri = liste.split("/");
        document.getElementById("kategori_id").value = kategori_bilgileri[0];
        document.getElementById("kategori_adi").value = kategori_bilgileri[1];
        document.getElementById("aciklama").value = kategori_bilgileri[2];
    }
</script>

</html>
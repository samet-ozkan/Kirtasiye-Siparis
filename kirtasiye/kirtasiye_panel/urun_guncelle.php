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
            $sql_urun_sil = "DELETE FROM urun WHERE urun_id = ?";
            $stmt_urun_sil = mysqli_prepare($link, $sql_urun_sil);
            if ($stmt_urun_sil) {
                mysqli_stmt_bind_param($stmt_urun_sil, "i", $_POST["urun_id"]);
                if (mysqli_stmt_execute($stmt_urun_sil)) {
                    echo "<script>window.alert('Başarılı: Ürün silindi.')</script>";
                } else {
                    echo "<script>window.alert('Hata: Ürün silinemedi.')</script>";
                }
                mysqli_stmt_close($stmt_urun_sil);
            }
        } else {
            if (@$_POST["urun_id"]) {
                $sql_urun_guncelle = "UPDATE urun SET urun_adi = ?, fiyat = ?, marka = ?, renk = ?, stok = ?, kategori_id = ? WHERE urun_id = ?";
                $stmt_urun_guncelle = mysqli_prepare($link, $sql_urun_guncelle);
                if ($stmt_urun_guncelle) {
                    mysqli_stmt_bind_param($stmt_urun_guncelle, "sdssiii", $_POST["urun_adi"], $_POST["fiyat"], $_POST["marka"], $_POST["renk"], $_POST["stok"], $_POST["kategori_id"], $_POST["urun_id"]);
                    if (mysqli_stmt_execute($stmt_urun_guncelle)) {
                        echo "<script>window.alert('Başarılı: Ürün güncellendi..')</script>";
                    } else {
                        echo "<script>window.alert('Hata: Ürün güncellenemedi. Tüm alanları doldurduğunuzdan emin olunuz.')</script>";
                    }
                    mysqli_stmt_close($stmt_urun_guncelle);
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
    <title>Ürün Güncelle</title>
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
                <h1 style="color: #0069D9">Ürün Güncelle</h1>
                <br>
                <div class="alert alert-warning" role="alert">
                    * Tüm alanların doldurulması zorunludur.
                </div>
                <select class="form-control" id="urun_listesi" onchange="formDoldur(value);">
                    <option value="0">Lütfen ürün seçin:</option>
                    <?php
                    $sql_kirtasiye = "SELECT kirtasiye_id FROM kirtasiye WHERE kirtasiye_sahibi = ?";
                    $stmt_kirtasiye = mysqli_prepare($link, $sql_kirtasiye);
                    mysqli_stmt_bind_param($stmt_kirtasiye, "i", $kirtasiye_sahibi);
                    mysqli_stmt_execute($stmt_kirtasiye);
                    mysqli_stmt_store_result($stmt_kirtasiye);
                    mysqli_stmt_bind_result($stmt_kirtasiye, $kirtasiye_id);
                    mysqli_stmt_fetch($stmt_kirtasiye);

                    $query = "SELECT * FROM urun CROSS JOIN kategori WHERE urun.kirtasiye_id = $kirtasiye_id and urun.kategori_id = kategori.kategori_id";
                    $result = mysqli_query($link, $query);
                    while ($rows = mysqli_fetch_assoc($result)) {
                    ?>
                        <script>
                            console.log("scripte girdi");
                            var urun = document.createElement("option");
                            urun.value = "<?php echo $rows["urun_id"] ?>/<?php echo $rows["urun_adi"] ?>/<?php echo $rows["fiyat"] ?>/<?php echo $rows["marka"] ?>/<?php echo $rows["renk"] ?>/<?php echo $rows["stok"] ?>/<?php echo $rows["kategori_id"] ?>/<?php echo $rows["kategori_adi"] ?> ";
                            urun.text = "<?php echo $rows["urun_adi"] ?>";
                            document.getElementById("urun_listesi").appendChild(urun);
                        </script>
                    <?php
                    }
                    ?>
                </select>
                <br>
                <form id="form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
                            </svg> <b>Ürün Adı:</b></label>
                        <input type="text" class="form-control" id="urun_adi" name="urun_adi" placeholder="Ürün adı giriniz.">
                    </div>
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
                            </svg> <b>Ürün ID:</b></label>
                        <input class="form-control" type="text" id="urun_id" name="urun_id" readonly>
                    </div>
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
                            </svg> <b>Kategori:</b></label>
                        <select class="form-control" id="kategori_listesi" onchange="kategoriIdAyarla(value);">
                            <option id="kategori"></option>
                            <?php
                            $query = "SELECT * FROM kategori WHERE kirtasiye_id = $kirtasiye_id";
                            $result = mysqli_query($link, $query);
                            while ($rows = mysqli_fetch_assoc($result)) {
                            ?>
                                <script>
                                    var option = document.createElement("option");
                                    option.id = '<?php echo $rows["kategori_id"] ?>';
                                    option.value = '<?php echo $rows["kategori_id"] ?>';
                                    option.text = '<?php echo $rows["kategori_adi"] ?>';
                                    document.getElementById("kategori_listesi").appendChild(option);
                                    console.log("scripte girdi option");
                                </script>
                            <?php
                            }

                            mysqli_free_result($result);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
                            </svg> <b>Kategori ID:</b></label>
                        <input class="form-control" type="text" id="kategori_id" name="kategori_id" readonly>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-4">
                                <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                        <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
                                    </svg> <b>Renk:</b></label>

                                <input type="text" class="form-control" placeholder="Renk giriniz." id="renk" name="renk">
                            </div>
                            <div class="col-4">
                                <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                        <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
                                    </svg> <b>Marka:</b></label>
                                <input type="text" class="form-control" placeholder="Marka giriniz." id="marka" name="marka">
                            </div>
                            <div class="col-4">
                                <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                        <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
                                    </svg> <b>Stok:</b></label>
                                <input type="number" class="form-control" placeholder="Stok giriniz." id="stok" name="stok">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
                            </svg> <b>Fiyat:</b></label>
                        <input type="number" step="any" class="form-control" id="fiyat" name="fiyat" placeholder="Fiyat giriniz.">
                    </div>
                    <button type="submit" class="btn btn-primary" name="islem" value="Kaydet">Kaydet</button>
                    <button type="submit" class="btn btn-danger" name="islem" value="Sil">Ürünü Sil</button>
                </form>
                <br>
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
<script>
    document.getElementById("form").style.visibility = "hidden";

    function kategoriIdAyarla(value) {
        document.getElementById("kategori_id").value = value;
    }

    function formDoldur(liste) {
        if (liste == 0) {
            document.getElementById("form").style.visibility = "hidden";
        } else {
            document.getElementById("form").style.visibility = "visible";
        }
        urun_bilgileri = liste.split("/");
        document.getElementById("urun_id").value = urun_bilgileri[0];
        document.getElementById("urun_adi").value = urun_bilgileri[1];
        document.getElementById("fiyat").value = urun_bilgileri[2];
        document.getElementById("marka").value = urun_bilgileri[3];
        document.getElementById("renk").value = urun_bilgileri[4];
        document.getElementById("stok").value = urun_bilgileri[5];
        document.getElementById("kategori_id").value = urun_bilgileri[6];
        document.getElementById("kategori").value = urun_bilgileri[6];
        document.getElementById("kategori").text = "### " + urun_bilgileri[7] + " ###";
    }
</script>

</html>
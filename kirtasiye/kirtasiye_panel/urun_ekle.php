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
        $sql = "INSERT INTO urun(urun_adi, fiyat, marka, renk, stok, kategori_id, kirtasiye_id) VALUES(?, ?, ?, ?, ?, ?, (SELECT kirtasiye_id FROM kirtasiye WHERE kirtasiye_sahibi = ?))";
        $stmt = mysqli_prepare($link, $sql);
        $urun_adi = $_POST["urun_adi"];
        $fiyat = $_POST["fiyat"];
        $marka = $_POST["marka"];
        $renk = $_POST["renk"];
        $stok = $_POST["stok"];
        $kategori_id = $_POST["kategori_id"];
        mysqli_stmt_bind_param($stmt, "sdssiii", $urun_adi, $fiyat, $marka, $renk, $stok, $kategori_id, $kirtasiye_sahibi);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>window.alert('Başarılı: Ürün eklendi.')</script>";
        } else {
            echo "<script>window.alert('Hata: Ürün eklenemedi. Tüm alanları doldurduğunuzdan emin olunuz.')</script>";
            echo "<script>window.alert('Dikkat: \"Kırtasiye Bilgileri\" sayfasındaki formu doldurmadan ürün eklenemez.')</script>";

        }
        mysqli_stmt_close($stmt);
        mysqli_close($link);
    }
}

?>

<!doctype html>
<html lang="tr">

<head>
    <title>Ürün Ekle</title>
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
                <h1 style="color: #0069D9">Ürün Ekle</h1>
                <br>
                <div class="alert alert-warning" role="alert">
                    * Tüm alanların doldurulması zorunludur.
                </div>
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
                            </svg> <b>Ürün Adı:</b></label>
                        <input type="text" class="form-control" id="urun_adi" name="urun_adi" placeholder="Ürün adı giriniz.">
                    </div>
                    <div class="form-group">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
                            </svg> <b>Kategori:</b></label>
                        <select class="form-control" id="kategori_listesi" onchange="kategoriIdAyarla(value);">
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
                                    document.write("<option value='<?php echo $rows["kategori_id"] ?>'><?php echo $rows["kategori_adi"] ?></option>");
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
                            </svg> <b>Kategori ID</b></label>
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
<script>
    function kategoriIdAyarla(value) {
        document.getElementById("kategori_id").value = value;
    }
</script>

</html>
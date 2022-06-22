<?php

require_once "config.php";
require_once "kullanici_tipi.php";

$query = "SELECT * FROM urun INNER JOIN kategori ON urun.kategori_id = kategori.kategori_id INNER JOIN kirtasiye ON kirtasiye.kirtasiye_id = urun.kirtasiye_id WHERE urun.stok>0 ORDER BY urun.urun_id DESC";
$result = mysqli_query($link, $query);
?>

<!doctype html>
<html lang="tr">

<head>
    <title>Ana Sayfa</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body style="background-color: #FCFCFC">
    <?php require_once dirname(__DIR__) . "/kirtasiye/navbar.php"; ?>
    <br>
    <div class="container" style="background-color: #FFF; border:1px solid #000">
        <div class="row">
            <div class="col-12">
                <br>
                <h1 style="color: #0069D9">Ürünler</h1>
                <br>
                <table class="table table-hover" id="urunler_tablosu">
                    <thead>
                        <tr>
                            <th scope="col"># Ürün No</th>
                            <th scope="col">Ürün Adı</th>
                            <th scope="col">Marka</th>
                            <th scope="col">Renk</th>
                            <th scope="col">Satıcı</th>
                            <th scope="col">Fiyat</th>
                            <th scope="col">Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($rows = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <th><?php echo $rows["urun_id"] ?></th>
                                <td><?php echo $rows["urun_adi"] ?></td>
                                <td><?php echo $rows["marka"] ?></td>
                                <td><?php echo $rows["renk"] ?></td>
                                <td><?php echo $rows["kirtasiye_adi"] ?></td>
                                <td><?php echo $rows["fiyat"] ?> ₺</td>
                                <td><a href="urun.php?urun_id=<?php echo $rows["urun_id"] ?>" class="btn btn-info" role="button">Ürüne Git</a></td>
                            </tr>
                        <?php
                        }
                        //mysqli_free_result($result);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <?php
        if ($result) {
            $sayac = 0;
            mysqli_data_seek($result, 0);
            while ($rows = mysqli_fetch_assoc($result)) {
                if ($sayac % 3 == 0) {
        ?> <div class="row">
                    <?php
                }
                    ?>
                    <div class="col-sm">
                        <div class="thumbnail" style="border:1px solid #0069D9">
                            <div class="caption">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                                            <div class="card-header">Satıcı Bilgileri</div>
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $rows["kirtasiye_adi"] ?></h5>
                                                <p class="card-text"><?php echo $rows["adres"] ?></p>
                                                <p class="card-text"><?php echo $rows["email"] ?></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <h3 class="card-title" style="color: #0069D9"><?php echo $rows["urun_adi"] ?></h3>
                                    </li>
                                    <li class="list-group-item"><b>Satıcı:</b> <?php echo $rows["kirtasiye_adi"] ?></li>
                                    <li class="list-group-item"><b>Marka:</b> <?php echo $rows["marka"] ?></li>
                                    <li class="list-group-item"><b>Kategori:</b> <?php echo $rows["kategori_adi"] ?></li>
                                    <li class="list-group-item"><b>Renk:</b> <?php echo $rows["renk"] ?></li>
                                    <li class="list-group-item"><b>Stok:</b> <?php echo $rows["stok"] ?> adet</li>
                                    <li class="list-group-item"><b>Fiyat:</b> <?php echo $rows["fiyat"] ?> ₺</li>
                                    <li class="list-group-item"><a href="urun.php?urun_id=<?php echo $rows["urun_id"] ?>" class="btn btn-primary" role="button">Sipariş Ver</a></li>
                            </div>
                        </div>
                    </div>

                    <?php
                    $sayac++;
                    if ($sayac % 3 == 0) {
                    ?>
                    </div> <br>
        <?php
                        if ($sayac == 6) {
                            break;
                        }
                    }
                }
            } else {
                echo "<script>console.log('olmadi');</script>";
            }

            mysqli_free_result($result);
            mysqli_close($link);
        ?>
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
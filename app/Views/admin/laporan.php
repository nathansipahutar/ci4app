<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<?php
$sqlPeriode = "";
$awalTgl = "";
$akhirTgl = "";
$tglAwal = "";
$tglAkhir = "";

if (isset($_POST['btnTampil'])) {
    $tglAwal = isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : "01-" . date('m-Y');
    $tglAkhir = isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : date('d-m-Y');
    $sqlPeriode = " where A.tglpesanan BETWEEN '" . $tglAwal . "' AND '" . $tglAkhir . "'";
} else {
    $awalTgl = "01-" . date('m-Y');
    $akhirTgl = date('d-m-Y');

    $sqlPeriode = " where A.tglpesanan BETWEEN '" . $awalTgl . "' AND '" . $akhirTgl . "'";
}
?>

<main class="page shopping-cart-page">
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Data Pemesanan</h3>
        <h4>Periode Tanggal <b><?php echo ($tglAwal); ?></b> s/d <b><?php echo ($tglAkhir); ?></b></h4>
        <div class="card shadow">
            <div class="card-header py-3">

            </div>
            <div class="card-body">
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form10" target="_self">
                    <div class="row">
                        <div class="col-lg-3">
                            <input type="date" name="txtTglAwal" class="form-control" value="<?php echo $awalTgl; ?>" size="10" id="">
                        </div>
                        <div class="col-lg-3">
                            <input type="date" name="txtTglAkhir" class="form-control" value="<?php echo $akhirTgl; ?>" size="10" id="">
                        </div>
                        <div class="col-lg-3">
                            <input type="submit" name="btnTampil" class="btn btn-success" value="Tampilkan" id="">
                        </div>
                    </div>
                </form>

                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table dataTable my-0" id="dataTable1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Pesanan</th>
                                <th>Tanggal Pesanan</th>
                                <th>Pembeli</th>
                                <th>Produk</th>
                                <th>Status</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT A.*, B."
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>
<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<?php

$sqlPeriode = "";
$awalTgl = "";
$akhirTgl = "";
$tglAwal = "";
$tglAkhir = "";

?>

<main class="page shopping-cart-page">
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Data Penjualan</h3>
        <h4>Periode Tanggal <b><?php echo ($tglAwal); ?></b> s/d <b><?php echo ($tglAkhir); ?></b></h4>
        <div class="card shadow">
            <div class="card-header py-3">

            </div>
            <div class="card-body">
                <form action="" method="post" name="form10" target="_self">
                    <div class="row">
                        <div class="col-lg-3">
                            <input type="date" name="txtTglAwal" class="form-control" value="<?php echo $awalTgl; ?>" size="10" id="txtTglAwal">
                        </div>
                        <div class="col-lg-3">
                            <input type="date" name="txtTglAkhir" class="form-control" value="<?php echo $akhirTgl; ?>" size="10" id="txtTglAkhir">
                        </div>
                        <div class="col-lg-3">
                            <input type="submit" name="btnTampil" class="btn btn-success" value="Tampilkan" id="">
                        </div>
                        <div class="col-lg-3">
                            <a href="<?= site_url('transaksi/lacakResi/'); ?>" class="btn btn-info">LIHAT</a>
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
                            <!-- bikin sesuai dengan id user -->
                            <?php foreach ($model as $index => $transaksi) : ?>
                                <tr>
                                    <td><?= $transaksi->id_transaksi; ?></td>
                                    <td><?= $transaksi->nama; ?></td>
                                    <td><?= $transaksi->username; ?></td>
                                    <td><?= $transaksi->alamat; ?></td>
                                    <td><?= $transaksi->jumlah; ?></td>
                                    <td><?= $transaksi->total_harga; ?></td>
                                    <td>
                                        <a href="<?= site_url('transaksi/view/' . $transaksi->id_transaksi); ?>" class="btn btn-primary">Bayar</a>
                                        <a href="<?= site_url('transaksi/invoice/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Invoice</a>
                                        <a href="<?= site_url('transaksi/lacakResi/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Lacak Resi</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</main>

</div>

<?= $this->endSection('page-content'); ?>
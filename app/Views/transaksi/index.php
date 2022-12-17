<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<h1>Transaksi</h1>
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('pesan'); ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('gagal')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('gagal'); ?>
    </div>
<?php endif; ?>
<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Barang</th>
            <th>Pembeli</th>
            <th>Alamat</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model as $index => $transaksi) : ?>
            <tr>
                <td><?= $transaksi->id_transaksi; ?></td>
                <td><?= $transaksi->nama; ?></td>
                <td><?= $transaksi->username; ?></td>
                <td><?= $transaksi->alamat; ?></td>
                <td><?= $transaksi->jumlah; ?></td>
                <td><?= $transaksi->total_harga; ?></td>
                <td>
                    <?php if ($transaksi->status == 'Menunggu konfirmasi pembayaran') { ?>
                        <a href="<?= site_url('/admin/cekPembayaran/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Cek Pembayaran</a>
                    <?php } ?>
                    <?php if ($transaksi->status == 'Produk sedang diproses') { ?>
                        <a href="<?= site_url('/admin/transaksi/inputResi/' . $transaksi->id_transaksi); ?>" class="btn btn-warning">Input Resi</a>
                    <?php } else { ?>
                        <p>selesai deh</p>
                    <?php } ?>

                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection('page-content'); ?>
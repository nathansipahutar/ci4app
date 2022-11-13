<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h1>Transaksi</h1>
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('pesan'); ?>
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
                    <a href="<?= site_url('/admin/transaksi/edit/' . $transaksi->id_transaksi); ?>" class="btn btn-primary">View</a>
                    <a href="<?= site_url('transaksi/invoice/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Invoice</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection(); ?>
<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h4>invoice</h4>
<table>
    <tr>
        <td>Barang</td>
        <td><?= $transaksi->nama; ?></td>
    </tr>
    <tr>
        <td>Pembeli</td>
        <td><?= $transaksi->username; ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td><?= $transaksi->alamat; ?></td>
    </tr>
    <tr>
        <td>Jumlah</td>
        <td><?= $transaksi->jumlah; ?></td>
    </tr>
    <tr>
        <td>No Transaksi</td>
        <td>TRX - <?= $transaksi->id; ?></td>
    </tr>
    <tr>
        <td>Total Harga</td>
        <td><?= $transaksi->total_harga; ?></td>
    </tr>
</table>
<?= $this->endSection(); ?>
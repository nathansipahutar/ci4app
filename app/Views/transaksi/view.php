<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h4>Satu langkah lagi untuk menyelesaikan transaksi</h4>
<p>Berikut adalah detail barang yang telah dibeli</p>

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
        <td>TRX - <?= $transaksi->id_transaksi; ?></td>
    </tr>
    <tr>
        <td>Total Harga</td>
        <td><?= $transaksi->total_harga; ?></td>
    </tr>
</table>

<p>Klik link berikut untuk menyelesaikan order</p>
<a href="<?= site_url('transaksi/user/'); ?>" class="btn btn-success">Bayar</a>
<?= $this->endSection(); ?>
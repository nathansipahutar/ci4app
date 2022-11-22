<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h1>Transaksi</h1>
<h2>test</h2>

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

<?= $this->endSection(); ?>
<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

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
            <th>Status</th>
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
                <td><?= $transaksi->status; ?></td>
                <td>
                    <?php if ($transaksi->status == 'Belum dibayar') { ?>
                        <a href="<?= site_url('transaksi/bayar/' . $transaksi->id_transaksi); ?>" class="btn btn-primary">Bayar</a>
                        <a href="<?= site_url('transaksi/invoice/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Invoice</a>
                        <form action="/transaksi/<?= $transaksi->id_transaksi = isset($transaksi->id_transaksi) ? $transaksi->id_transaksi : ''; ?>" method="post" class="d-inline">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?')">Delete</button>
                        </form>
                    <?php } ?>
                    <?php if ($transaksi->status == 'Bukti pembayaran salah') { ?>
                        <a href="<?= site_url('transaksi/bayar/' . $transaksi->id_transaksi); ?>" class="btn btn-primary">Bayar</a>
                        <a href="<?= site_url('transaksi/invoice/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Invoice</a>
                    <?php } ?>

                    <?php if ($transaksi->status == 'Produk sedang diantar') { ?>
                        <a href="<?= site_url('transaksi/lacakResi/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Lacak Resi</a>
                    <?php } ?>
                    <?php if ($transaksi->status == 'Produk siap dijemput di toko') { ?>
                        <a href="<?= site_url('/pages/contact'); ?>" class="btn btn-warning">Lihat Alamat Toko</a>
                    <?php } ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection(); ?>
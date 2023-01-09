<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container">
    <div class="admin-container-page">
        <h1>List Pesanan</h1>
        <p>Diurutkan dengan user</p>
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
                    <th>Id Transaksi</th>
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
                                <?php if ($transaksi->metode_pengiriman == 'Diantar Kurir') { ?>
                                    <a href="<?= site_url('/admin/transaksi/inputResi/' . $transaksi->id_transaksi); ?>" class="btn btn-warning">Input Resi</a>
                                <?php } ?>
                                <?php if ($transaksi->metode_pengiriman == 'Dijemput ke toko') { ?>
                                    <a href="<?= site_url('/admin/transaksi/produkSelesai/' . $transaksi->id_transaksi); ?>" class="btn btn-warning">Produk Siap Dijemput</a>
                                <?php } ?>
                            <?php } ?>

                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <div style='margin-top: 10px;'>
            <?= $pager->links() ?>
        </div>
    </div>
</div>



<?= $this->endSection('page-content'); ?>
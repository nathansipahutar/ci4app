<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="user-transaksi-container">
    <div class="row">
        <h2 class="text-center">List Transaksi <?= $username; ?></h2>
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
                    <th>ID Produk</th>
                    <th>Produk</th>
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
                        <td class="action-list-transaksi">
                            <?php if ($transaksi->status == 'Belum dibayar') { ?>
                                <a href="<?= site_url('transaksi/bayar/' . $transaksi->id_transaksi); ?>" class="btn btn-primary">Bayar</a>
                                <a href="<?= site_url('transaksi/invoice/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Invoice</a>
                                <form action="/transaksi/delete/<?= $transaksi->id_transaksi = isset($transaksi->id_transaksi) ? $transaksi->id_transaksi : ''; ?>" method="post" class="d-inline">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?')">Batal</button>
                                </form>
                            <?php } ?>
                            <?php if ($transaksi->status == 'Bukti pembayaran salah') { ?>
                                <a href="<?= site_url('transaksi/bayar/' . $transaksi->id_transaksi); ?>" class="btn btn-primary">Bayar</a>
                                <a href="<?= site_url('transaksi/invoice/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Invoice</a>
                            <?php } ?>

                            <?php if ($transaksi->status == 'Produk sedang diantar') { ?>
                                <a href="<?= site_url('transaksi/lacakResi/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Lacak Resi</a>
                                <a href="<?= site_url('transaksi/selesai/' . $transaksi->id_transaksi); ?>" class="btn btn-primary">Pesanan Sampai</a>
                            <?php } ?>
                            <?php if ($transaksi->status == 'Produk siap dijemput di toko') { ?>
                                <a href="<?= site_url('/pages/contact'); ?>" class="btn btn-success">Lihat Alamat Toko</a>
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

<div class="responsive-list-transaksi">
    <h2 class="text-center">List Transaksi <?= $username; ?></h2>
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

    <div class="list-card-list-transaksi col-sm-6">
        <?php foreach ($model as $index => $transaksi) : ?>
            <div class="list-transaksi-card card">
                <div class="card-body">
                    <h5 class="nama-list-transaksi card-title"><?= $transaksi->nama; ?></h5>
                    <p class="harga-list-transaksi card-text"><?= $transaksi->total_harga; ?></p>
                    <p class="card-text text-muted">Status : <?= $transaksi->status; ?></p>

                    <?php if ($transaksi->status == 'Belum dibayar') { ?>
                        <a href="<?= site_url('transaksi/bayar/' . $transaksi->id_transaksi); ?>" class="btn btn-primary">Bayar</a>
                        <a href="<?= site_url('transaksi/invoice/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Invoice</a>
                        <form action="/transaksi/delete/<?= $transaksi->id_transaksi = isset($transaksi->id_transaksi) ? $transaksi->id_transaksi : ''; ?>" method="post" class="d-inline">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?')">Batal</button>
                        </form>
                    <?php } ?>
                    <?php if ($transaksi->status == 'Bukti pembayaran salah') { ?>
                        <a href="<?= site_url('transaksi/bayar/' . $transaksi->id_transaksi); ?>" class="btn btn-primary">Bayar</a>
                        <a href="<?= site_url('transaksi/invoice/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Invoice</a>
                    <?php } ?>

                    <?php if ($transaksi->status == 'Produk sedang diantar') { ?>
                        <a href="<?= site_url('transaksi/lacakResi/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Lacak Resi</a>
                        <a href="<?= site_url('transaksi/selesai/' . $transaksi->id_transaksi); ?>" class="btn btn-primary">Pesanan Sampai</a>
                    <?php } ?>
                    <?php if ($transaksi->status == 'Produk siap dijemput di toko') { ?>
                        <a href="<?= site_url('/pages/contact'); ?>" class="btn btn-success">Lihat Alamat Toko</a>
                    <?php } ?>
                </div>
            </div>
        <?php endforeach ?>
        <div style='margin-top: 10px;'>
            <?= $pager->links() ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
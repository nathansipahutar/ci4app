<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container container-cekPembayaran">
    <div class="cek-bayar-container row">
        <div class="col-6">

            <h2>Cek Pembayaran</h2>
            <form action="/admin/prosesProduk/<?= $transaksi->id_transaksi; ?>" method="post" enctype="multipart/form-data">
                <!-- crsf agar form hanya dapat diakses di halaman ini -->
                <?= csrf_field(); ?>
                <input type="hidden" name="id_transaksi" id="" value="<?= $transaksi->id_transaksi; ?>">

                <div class=" form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Pembeli</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control" id="username" name="username" value="<?= (old('username')) ? old('username') : $model->username ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Produk</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control" id="nama" name="nama" value="<?= (old('nama')) ? old('nama') : $model->nama  ?>">
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="jumlah" class="col-sm-2 col-form-label">Jumlah Pembelian</label>
                    <div class="col-sm-10">
                        <input readonly type="number" class="form-control" id="jumlah" name="jumlah" value="<?= (old('jumlah')) ? old('jumlah') : $model->jumlah ?>">
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="nama_bank" class="col-sm-2 col-form-label">Nama Bank</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control" id="nama_bank" name="nama_bank" value="<?= (old('nama_bank')) ? old('nama_bank') : $model->nama_bank ?>">
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="atas_nama" class="col-sm-2 col-form-label">Atas Nama</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control" id="atas_nama" name="atas_nama" value="<?= (old('atas_nama')) ? old('atas_nama') : $model->atas_nama ?>">
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="total_harga" class="col-sm-2 col-form-label">Total Harga</label>
                    <div class="col-sm-10">
                        <input readonly type="number" class="form-control" id="total_harga" name="total_harga" value="<?= (old('total_harga')) ? old('total_harga') : $model->total_harga ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <input class="btn btn-warning" name="submit" value="bukti salah" aria-label="halo" type="submit">
                        <input class="btn btn-primary" name="submit" value="bukti benar" type="submit">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-6">
            <img class="img_bukti-bayar" style="max-width: 600px;" src="/img/<?= $model->bukti_bayar; ?>" alt="">
        </div>
    </div>
</div>
<?= $this->endSection('page-content'); ?>
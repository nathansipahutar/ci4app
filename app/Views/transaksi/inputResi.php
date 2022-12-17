<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3">Form Edit Data Pesanan</h2>

            <form action="/admin/transaksi/simpanResi/<?= $transaksi->id_transaksi; ?>" method="post" enctype="multipart/form-data">
                <!-- crsf agar form hanya dapat diakses di halaman ini -->
                <?= csrf_field(); ?>
                <input type="hidden" name="id_transaksi" id="" value="<?= $transaksi->id_transaksi; ?>">

                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Barang</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= (old('nama')) ? old('nama') : $model->nama  ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama'); ?>
                        </div>
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Pembeli</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" id="username" name="username" value="<?= (old('username')) ? old('username') : $model->username ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('username'); ?>
                        </div>
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" id="alamat" name="alamat" value="<?= (old('alamat')) ? old('alamat') : $transaksi->alamat ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('alamat'); ?>
                        </div>
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
                    <div class="col-sm-10">
                        <input readonly type="number" class="form-control <?= ($validation->hasError('jumlah')) ? 'is-invalid' : ''; ?>" id="jumlah" name="jumlah" value="<?= (old('jumlah')) ? old('jumlah') : $transaksi->jumlah ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('jumlah'); ?>
                        </div>
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="total_harga" class="col-sm-2 col-form-label">Total Harga</label>
                    <div class="col-sm-10">
                        <input readonly type="number" class="form-control <?= ($validation->hasError('total_harga')) ? 'is-invalid' : ''; ?>" id="total_harga" name="total_harga" value="<?= (old('total_harga')) ? old('total_harga') : $transaksi->total_harga ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('total_harga'); ?>
                        </div>
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="kode_resi" class="col-sm-2 col-form-label">Kode Resi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('kode_resi')) ? 'is-invalid' : ''; ?>" autofocus id="kode_resi" name="kode_resi" value="<?= (old('kode_resi')) ? old('kode_resi') : $transaksi->kode_resi ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('kode_resi'); ?>
                        </div>
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control <?= ($validation->hasError('status')) ? 'is-invalid' : ''; ?>" id="status" name="status" value="<?= (old('status')) ? old('status') : $transaksi->status ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('status'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Edit Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
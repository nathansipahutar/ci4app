<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3">Form Edit Data Product</h2>

            <form action="/product/update/<?= $products['id']; ?>" method="post" enctype="multipart/form-data">
                <!-- crsf agar form hanya dapat diakses di halaman ini -->
                <?= csrf_field(); ?>
                <input type="hidden" name="slug" id="" value="<?= $products['slug']; ?>">
                <input type="hidden" name="gambarLama" value="<?= $products['gambar']; ?>">

                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" autofocus value="<?= (old('nama')) ? old('nama') : $products['nama'] ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama'); ?>
                        </div>
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : ''; ?>" id="harga" name="harga" value="<?= (old('harga')) ? old('harga') : $products['harga'] ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('harga'); ?>
                        </div>
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="stok" class="col-sm-2 col-form-label">Stock</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control <?= ($validation->hasError('stok')) ? 'is-invalid' : ''; ?>" id="stok" name="stok" value="<?= (old('stok')) ? old('stok') : $products['stok'] ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('stok'); ?>
                        </div>
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                    <div class="col-sm-2">
                        <img src="/img/<?= $products['gambar']; ?>" class="img-thumbnail img-preview">
                    </div>
                    <div class="col-sm-10">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?= ($validation->hasError('gambar')) ? 'is-invalid' : ''; ?>" id="gambar" name="gambar" onchange="previewImg()">
                            <div class="invalid-feedback">
                                <?= $validation->getError('gambar'); ?>
                            </div>
                            <label class="custom-file-label" for="gambar"><?= $products['gambar']; ?></label>
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
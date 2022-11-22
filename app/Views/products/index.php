<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?= $i = 1; ?>
<div class="container">
    <div class="row">
        <!-- CARDS -->
        <?php foreach ($products_snack as $p) : ?>
            <div class="col-4">
                <div class="card text-center">
                    <div class="card-header">
                        <span class="text-success">
                            <strong><?= $p['nama']; ?></strong>
                        </span>
                    </div>
                    <div class="card-body">
                        <img src="/img/<?= $p['gambar']; ?>" alt="Products picture" class="img-thumbnail" style="max-width: 150px">
                        <h5 class="mt-3 text-success"><?= "Rp " .  $p['harga']; ?></h5>
                        <p class="text-info">Stok : <?= $p['stok']; ?></p>
                    </div>
                    <div class="card-footer">
                        <a style="width: 50%;" class="btn btn-info" href="/product/beli/jemput/<?= $p['slug']; ?>">Ambil di Toko</a>
                        <a style="width: 50%;" class="btn btn-success" href="/product/beli/antar/<?= $p['slug']; ?>">Diantar</a>
                        <a style="width: 100%;" class="btn btn-success" href="/product/beli/<?= $p['slug']; ?>">Beli</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <hr>
        <br>
        <br>
        <h1>PEMBATAS</h1>
        <br>
        <br>
        <br>
        <?php foreach ($products_rajutan as $p) : ?>
            <div class="col-4">
                <div class="card text-center">
                    <div class="card-header">
                        <span class="text-success">
                            <strong><?= $p['nama']; ?></strong>
                        </span>
                    </div>
                    <div class="card-body">
                        <img src="/img/<?= $p['gambar']; ?>" alt="Products picture" class="img-thumbnail" style="max-width: 150px">
                        <h5 class="mt-3 text-success"><?= "Rp " .  $p['harga']; ?></h5>
                        <p class="text-info">Stok : <?= $p['stok']; ?></p>
                    </div>
                    <div class="card-footer">
                        <a style="width: 100%;" class="btn btn-success" href="/product/beli/<?= $p['slug']; ?>">Beli</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- NORMAL -->
        <div class="col">
            <a href="/products/create" class="btn btn-primary mt-3">Tambah Data Product</a>
            <h1 class="mt-2">Daftar Product</h1>
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sampul</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($products as $p) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><img src="/img/<?= $p['gambar']; ?>" alt="" class="sampul"></td>
                            <td><?= $p['nama']; ?></td>
                            <td>
                                <a href="/products/<?= $p['slug']; ?>" class="btn btn-success">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
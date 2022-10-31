<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<?= $i = 1; ?>
<div class="container">
    <div class="row">
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
<?= $this->endSection('page-content'); ?>
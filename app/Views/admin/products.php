<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<?php $i = 1 ?>


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
            <?php if (session()->getFlashdata('cancel')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('cancel'); ?>
                </div>
            <?php endif; ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Sampul</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($products as $p) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><img src="/img/<?= $p['gambar']; ?>" alt="" class="sampul"></td>
                            <td><?= $p['nama']; ?></td>
                            <td><?= $p['harga']; ?></td>
                            <td>
                                <a href="/products/<?= $p['slug']; ?>" class="btn btn-success">Detail</a>
                                <a href="/product/edit/<?= $p['slug']  = isset($p['slug']) ? $p['slug'] : ''; ?>" class="btn btn-warning">Edit</a>

                                <form action="/admin/products/delete/<?= $p['id_barang'] = isset($p['id_barang']) ? $p['id_barang'] : ''; ?>" method="post" class="d-inline">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection('page-content'); ?>
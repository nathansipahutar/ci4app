<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mt-2">Detail Produk</h2>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row">
                    <!-- <div class="row no-gutters"> -->
                    <div class="col-md-4 img-detail-product">
                        <img src="/img/<?= $products['gambar'] = isset($products['gambar']) ? $products['gambar'] : '' ?>" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $products['nama'] = isset($products['nama']) ? $products['nama'] : ''; ?></h5>
                            <p class="card-text"><b><?= $products['harga'] = isset($products['harga']) ? $products['harga'] : ''; ?></b></p>
                            <p class="card-text text-secondary">kategori : <?= $products['kategori'] = isset($products['kategori']) ? $products['kategori'] : ''; ?></p>
                            <p class="card-text text-secondary"><?= $products['deskripsi'] = isset($products['deskripsi']) ? $products['deskripsi'] : ''; ?></p>

                            <a href="/product/edit/<?= $products['slug']  = isset($products['slug']) ? $products['slug'] : ''; ?>" class="btn btn-warning">Edit</a>

                            <form action="/admin/products/delete/<?= $products['id_barang'] = isset($products['id_barang']) ? $products['id_barang'] : ''; ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?')">Delete</button>
                            </form>

                            <br><br>
                            <a href="/admin/products">Kembali ke halaman kelola produk</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
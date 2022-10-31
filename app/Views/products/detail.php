<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mt-2">Detail Produk</h2>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/img/<?= $products['gambar'] = isset($products['gambar']) ? $products['gambar'] : '' ?>" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $products['nama'] = isset($products['nama']) ? $products['nama'] : ''; ?></h5>
                            <p class="card-text"><b><?= $products['harga'] = isset($products['harga']) ? $products['harga'] : ''; ?></b></p>
                            <p class="card-text"><small class="text-muted">Stock = <?= $products['stok'] = isset($products['stok']) ? $products['stok'] : ''; ?></small></p>

                            <a href="/product/edit/<?= $products['slug']  = isset($products['slug']) ? $products['slug'] : ''; ?>" class="btn btn-warning">Edit</a>

                            <form action="/products/<?= $products['id_barang'] = isset($products['id_barang']) ? $products['id_barang'] : ''; ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?')">Delete</button>
                            </form>

                            <br><br>
                            <a href="/products">Kembali ke daftar komik</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
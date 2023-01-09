<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?php $i = 1; ?>

<div class="container products-bg">
    <div class="heading-products">
        <h2 class="text-center ">Daftar Produk Snack Bouquet</h2>
        <p>Silahkan pilih salah satu produk yang kamu suka dan lakukan transaksi pembelian!</p>
    </div>
    <div class="row">
        <section>
            <div class=" container py-5">
                <div class="row justify-content-center">
                    <!-- CARDS -->
                    <?php foreach ($products_snack as $p) : ?>
                        <div class="col-xl-4 products-card">
                            <div class="border-card card text-black">
                                <img src="/img/<?= $p['gambar']; ?>" class="card-img-top" alt="Apple Computer" />
                                <div class="card-body">
                                    <div class="">
                                        <h5 class="judul-produk "><?= $p['nama']; ?></h5>
                                        <span><?= "Rp " .  $p['harga']; ?></span>
                                    </div>
                                    <div class="d-flex deskripsi">
                                        <p class="text-muted mb-4"><?= $p['deskripsi']; ?></p>
                                    </div>
                                    <a style="width: 100%;" class="btn btn-success" href="/product/beli2/<?= $p['slug']; ?>">Jemput di toko</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </div>
</div>
<?= $this->endSection(); ?>
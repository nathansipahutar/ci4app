<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <h2 class="products-list-page" style="text-align: center;">Produk kami</h2>
        <div class="page-products products-container container">
            <div class="card col-lg-6">
                <div class="card-content">
                    <h2>Snack Bouquet</h2>
                    <p>
                        Bouquet berisi berbagai macam snack untuk teman kamu yang sedang berbahagia~
                    </p>
                    <a class="btn btn-primary" href="/product/snack">Beli Produk</a>
                </div>
                <img class="products-bouquet" src="/img/snack.png" alt="Snack Bouquet">
            </div>
            <div class="card col-lg-6">
                <div class="card-content ">
                    <h2>Rajutan</h2>
                    <p>
                        Dibuat dari benang wol terbaik yang dirajut secara <i><b>handmade</b></i> khusus untuk kamu!
                    </p>
                    <a class="btn btn-primary" href="/product/rajutan">Beli Produk</a>
                </div>
                <img class="products-rajutan" src="/img/rajutan.png" alt="Rajutan">
            </div>
        </div>
    </div>
    <div class="products-container-handphone">
        <div class="products-list-hp">
            <div class="card" style="width: 22rem;">
                <img src="/img/snack.png" class="card-img-top" alt="Snack Bouquet">
                <div class="card-body">
                    <h2 class="card-title"><b> Snack Bouquet </b></h5>
                        <p class="card-text">Bouquet berisi berbagai macam snack untuk teman kamu yang sedang berbahagia!</p>
                        <a href="/product/snack" class="btn btn-primary">Beli Produk</a>
                </div>
            </div>
            <div class="card" style="width: 22rem;">
                <img src="/img/rajutan.png" class="card-img-top" alt="Snack Bouquet">
                <div class="card-body">
                    <h2 class="card-title"><b> Rajutan </b></h5>
                        <p class="card-text">Dibuat dari benang wol terbaik yang dirajut secara <i><b>handmade</b></i> khusus untuk kamu!</p>
                        <a href="/product/rajutan" class="btn btn-primary">Beli Produk</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!-- <div class="container">
    <div class="row">
        <div class="col">
            <h1>Home Section</h1>
        </div>
    </div>
</div> -->
<div class="hero-header">
    <div class="hero-container container">
        <div class="row">
            <div class="hero-content content">
                <div class="textBoxHome" data-aos="fade-up" data-aos-duration="1100">
                    <h1>Butuh kado untuk orang terdekatmu?<span>Jawabannya disini!</span></h1>
                    <p>Silahkan klik tombol dibawah ini untuk menelusuri lebih lanjut mengenai produk kami</p>
                    <a class="web-btn-hero" href="#products-categories">Pesan Kado</a>
                    <a class="hp-btn-hero" href="#products-categories2">Pesan Kado</a>
                </div>
                <div class="imgBoxHome">
                    <img src="/img/hero.png" alt="" class="imgHome" data-aos="zoom-in" data-aos-duration="1100">
                </div>
                <ul class="sci" data-aos="fade-up" data-aos-duration="1100">
                    <li><a href="https://www.instagram.com/bunchofgift/"><i class="fa-brands fa-instagram"></i></a></li>
                    <li><a href="https://wa.me/+6281399901420"><i class="fa-brands fa-whatsapp"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<main>
    <div id="products-categories" class="products-container container" data-aos="fade-up" data-aos-duration="1200">
        <div class="row">
            <h2 class="products-list-heading" style="text-align: center;">Produk kami</h2>
            <div class="products-list d-flex flex.row">
                <div class="card col-lg-6">
                    <div class="card-content">
                        <h2>Snack Bouquet</h2>
                        <p>
                            Bouquet berisi berbagai macam snack untuk teman kamu yang sedang berbahagia!
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
                    <img class="products-rajutan" src="/img/rajutan.png" alt="Snack Bouquet">
                </div>
            </div>
        </div>
    </div>
    <div id="products-categories2" class="products-container-handphone">
        <div class="products-list-hp">
            <h2 class="products-list-heading" style="text-align: center;">Produk kami</h2>
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
    <div id="aboutUs" class="features">

        <div class="container" data-aos="fade-up" data-aos-duration="1200">

            <!-- About Us -->
            <div id="about" class="row feture-tabs about-us" data-aos="fade-up">
                <div class="col-lg-6 about-us-content">
                    <h3>Tentang Kami</h3>
                    <p>Bunch of Gifts berdiri sejak tahun 2018 dengan fokus menjual produk-produk <i><b>handmade</b></i> kepada pelanggan. Kami memastikan bahwa produk yang kami jual adalah <i><b>100% handmade</b></i> dan dibuat dari bahan-bahan yang berkualitas.</p>
                </div>

                <div class="maps col-lg-6">
                    <iframe class="maps-frame" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.70927967415!2d106.78914841529573!3d-6.301877663431043!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ee205863d129%3A0x88e26998d64ab4a9!2sJl.%20Lb.%20Bulus%20III%20No.28%2C%20RT.9%2FRW.7%2C%20Cilandak%20Bar.%2C%20Kec.%20Cilandak%2C%20Kota%20Jakarta%20Selatan%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2012450!5e0!3m2!1sid!2sid!4v1671773224209!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

            </div>
            <!-- End About Us -->
        </div>

    </div>
</main>

<?= $this->endSection(); ?>
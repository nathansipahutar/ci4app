<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!-- <div class="container">
    <div class="row">
        <div class="col">
            <h1>Home Section</h1>
        </div>
    </div>
</div> -->
<section>
    <div class="circle"></div>
    <div class="content">
        <div class="textBoxHome">
            <h2>It's not just a Gift <br>It's <span>Bunch of Gifts</span></h2>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos nemo ipsum commodi laborum, corrupti et facere adipisci?
                Unde nisi laborum necessitatibus enim quaerat nulla fugit repellat? Soluta ipsum maxime voluptate?</p>
            <a href="#">Learn More</a>
        </div>
        <div class="imgBoxHome">
            <img src="/img/snack.png" alt="" class="imgHome">
        </div>
    </div>
    <ul class="thumb">
        <li><img src="/img/thumb-snack.png" onclick="imgSlider('/img/thumb-snack.png'); changeCircleColor('#017143')" alt=""></li>
        <li><img src="/img/thumb-mug.png" onclick="imgSlider('/img/thumb-mug.png'); changeCircleColor('#eb7495')" alt=""></li>
        <li><img src="/img/thumb-natal.png" onclick="imgSlider('/img/thumb-natal.png'); changeCircleColor('#d752b1')" alt=""></li>
    </ul>
    <!-- UBAH JADI LOGO SOCMED -->
    <ul class="sci">
        <li><a href="#">Facebook</a></li>
        <li><a href="#">Twitter</a></li>
        <li><a href="#">Instagram</a></li>
    </ul>
</section>
<?= $this->endSection(); ?>
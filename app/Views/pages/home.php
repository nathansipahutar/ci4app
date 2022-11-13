<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!-- <div class="container">
    <div class="row">
        <div class="col">
            <h1>Home Section</h1>
        </div>
    </div>
</div> -->
<header>
    <div class="circle"></div>
    <div class="content">
        <div class="textBoxHome">
            <h1>It's not just a Gift <br>It's <span>Bunch of Gifts</span></h1>
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
        <li><a href="https://www.facebook.com/"><i class="fa-brands fa-facebook" style="color: white; font-size: 45px;"></i></a></li>
        <li><a href="https://www.instagram.com/"><i class="fa-brands fa-instagram" style="color: white; font-size: 45px;"></i></a></li>
        <li><a href="https://web.whatsapp.com/"><i class="fa-brands fa-whatsapp" style="color: white; font-size: 45px;"></i></a></li>
    </ul>
</header>
<main>
    <h3>This is main</h3>
</main>
<!-- <footer class="footer-16371">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 text-center">
                <div class="footer-site-logo mb-4">
                    <a href="#">Bunch of Gifts</a>
                </div>
                <ul class="list-unstyled nav-links mb-5">
                    <li><a href="#">About</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Press</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Legal</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>

                <div class="social mb-4">
                    <h3>Stay in touch</h3>
                    <ul class="list-unstyled">
                        <li class="in"><a href="#"><span class="icon-instagram"></span></a></li>
                        <li class="fb"><a href="#"><span class="icon-facebook"></span></a></li>
                        <li class="tw"><a href="#"><span class="icon-twitter"></span></a></li>
                        <li class="pin"><a href="#"><span class="icon-pinterest"></span></a></li>
                        <li class="dr"><a href="#"><span class="icon-dribbble"></span></a></li>
                    </ul>
                </div>

                <div class="copyright">
                    <p class="mb-0"><small>&copy; Bunch of Gifts. All Rights Reserved.</small></p>
                </div>


            </div>
        </div>
    </div>
</footer> -->
<?= $this->endSection(); ?>
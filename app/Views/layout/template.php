<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- ADD -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap CSS -->
    <link href="<?= base_url(); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- MY CSS -->
    <link href="<?= base_url(); ?>/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/home.css">
    <script src="https://kit.fontawesome.com/2ac80a6632.js" crossorigin="anonymous"></script>

    <!-- FOOTER CSS -->
    <link rel="stylesheet" href="/fonts/icomoon/style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">



    <!-- Style CSS -->
    <link rel="stylesheet" href="/css/style.css">
    <title><?= $title; ?></title>
</head>

<body>
    <?= $this->include('layout/navbar'); ?>
    <!-- CONTENT -->
    <?= $this->renderSection('content'); ?>

    <!-- Footer -->
    <footer class="footer-16371">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 text-center">
                    <div class="footer-site-logo mb-4">
                        <a href="#">Bunch of Gifts</a>
                    </div>
                    <ul class="list-unstyled nav-links mb-5">
                        <li><a href="<?= base_url('/'); ?>">Home</a></li>
                        <li><a href="<?= base_url('/pages/about'); ?>">About</a></li>
                        <li><a href="<?= base_url('/products'); ?>">Products</a></li>
                        <li><a href="<?= base_url('/pages/contact'); ?>">Contact Us</a></li>
                        <li><a href="#">My Order</a></li>
                        <li><a href="<?= base_url('login'); ?>">Login</a></li>
                    </ul>

                    <div class="social mb-4">
                        <h3>Stay in touch</h3>
                        <ul class="list-unstyled">
                            <li class="in"><a href="https://www.instagram.com/"><span class="icon-instagram"></span></a></li>
                            <li class="fb"><a href="https://www.facebook.com/"><span class="icon-facebook"></span></a></li>
                            <li class="tw"><a href="https://twitter.com/home"><span class="icon-twitter"></span></a></li>
                            <li class="pin"><a href="https://id.pinterest.com/"><span class="icon-pinterest"></span></a></li>
                            <li class="dr"><a href="https://web.whatsapp.com/"><span class="icon-whatsapp"></span></a></li>
                        </ul>
                    </div>

                    <div class="copyright">
                        <p class="mb-0"><small>&copy; Bunch of Gifts. All Rights Reserved.</small></p>
                    </div>


                </div>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        function previewImg() {
            const gambar = document.querySelector('#gambar');
            const gambarLabel = document.querySelector('.custom-file-label');
            const imgPreview = document.querySelector('.img-preview');

            gambarLabel.textContent = gambar.files[0].name;

            const fileBuktiBayar = new FileReader();
            fileGambar.readAsDataURL(gambar.files[0]);

            fileGambar.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }

        function previewImgBayar() {
            const gambarBuktiBayar = document.querySelector('#bukti_bayar');
            const gambarLabelBayar = document.querySelector('.custom-file-label');
            const imgPreview = document.querySelector('.img-preview');

            gambarLabelBayar.textContent = gambarBuktiBayar.files[0].name;

            const fileBuktiBayar = new FileReader();

            fileBuktiBayar.readAsDataURL(gambarBuktiBayar.files[0]);

            fileBuktiBayar.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }
    </script>
    <script type="text/javascript">
        function imgSlider(anything) {
            document.querySelector('.imgHome').src = anything;
        }

        function changeCircleColor(color) {
            const circle = document.querySelector('.circle');
            circle.style.background = color;
        }
    </script>
    <?= $this->renderSection('script') ?>
</body>

</html>
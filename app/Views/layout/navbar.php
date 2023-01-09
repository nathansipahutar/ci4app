<nav class="navbar-css navbar navbar-expand-lg navbar-light">
    <div class="container navbar-king-container" style="width: 100%;">
        <div class="responsive-hp-navbar">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="logo-container">
                <a class="navbar-brand" href="<?= base_url('/'); ?>"><img style="max-height: 2em;" src="/img/logo.png" alt=""></a>
            </div>
        </div>
        <div class="navbar-links-container" id="navbar-links-container">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="navbar-item-home nav-item home <?= $statusNav == 'home' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= base_url('/'); ?>">Home </a>
                    </li>
                    <li class="navbar-item-home nav-item about <?= $statusNav == 'about' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= base_url('/'); ?>#aboutUs">Tentang Kami</a>
                    </li>
                    <li class="navbar-item-home nav-item products <?= $statusNav == 'products' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= base_url('/products'); ?>">Produk</a>
                    </li>
                    <li class="navbar-item-home nav-item order <?= $statusNav == 'order' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= base_url('/transaksi/user'); ?>">Pesanan Saya</a>
                    </li>
                    <li class="navbar-item-home nav-item contact <?= $statusNav == 'contact' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= base_url('/pages/contact'); ?>">Hubungi Kami</a>
                    </li>
                    <?php if (session()->has('isLogin')) :  ?>
                        <li class="navbar-item-home nav-item profile <?= $statusNav == 'profile' ? 'active' : '' ?>">
                            <a class="nav-link" href="<?= base_url('/user'); ?>">Profil</a>
                        </li>
                        <li class="navbar-item-home nav-item">
                            <a class=" btn btn-outline-dark" href="<?= base_url('/logout'); ?>">Logout</a>
                        </li>
                    <?php else : ?>
                        <li class="navbar-item-home nav-item">
                            <a class=" btn btn-dark" href="<?= base_url('/login'); ?>">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>


    </div>
</nav>
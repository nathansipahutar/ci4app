<div class="sidebar-admin">
    <ul class=" navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin'); ?>">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Bunch of Gifts</div>
        </a>

        <!-- USER -->
        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Fiture
        </div>

        <!-- Nav Item - Charts -->
        <li class="nav-item <?= $statusSide == 'dashboard' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('admin'); ?>">
                <i class="fa-solid fa-users"></i>
                <span>Dashboard</span></a>
        </li>
        <li class="nav-item <?= $statusSide == 'product' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('/admin/products'); ?>">
                <i class="fa-solid fa-shop"></i>
                <span>Kelola Produk</span></a>
        </li>
        <li class="nav-item <?= $statusSide == 'pesanan' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('/transaksi/index'); ?>">
                <i class="fa-solid fa-shopping-cart"></i>
                <span>Kelola Pesanan</span></a>
        </li>
        <li class="nav-item <?= $statusSide == 'laporan' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('/admin/laporan'); ?>">
                <i class="fa-solid fa-file"></i>
                <span>Laporan</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <li class="nav-item <?= $statusSide == 'logout' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('/logout'); ?>">
                <i class="fa-sharp fa-solid fa-right-from-bracket"></i>
                <span>Logout</span></a>
        </li>

    </ul>
</div>
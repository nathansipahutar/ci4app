<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Bunch of Gifts</div>
    </a>

    <!-- ADMIN -->
    <?php if (in_groups('admin')) : ?>
        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Fiture
        </div>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin'); ?>">
                <i class="fa-solid fa-users"></i>
                <span>Manage Users</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/admin/products'); ?>">
                <i class="fa-solid fa-shop"></i>
                <span>Manage Products</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/transaksi/index'); ?>">
                <i class="fa-solid fa-shop"></i>
                <span>Manage Transaction</span></a>
        </li>

    <?php endif; ?>
    <!-- END ADMIN -->

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
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('user'); ?>">
            <i class="fa-solid fa-user"></i>
            <span>Profile</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fa-solid fa-tag"></i>
            <span>Products</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('logout'); ?>">
            <i class="fa-sharp fa-solid fa-right-from-bracket"></i>
            <span>Logout</span></a>
    </li>

</ul>
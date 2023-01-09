<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?php
$session = session();
$login = $session->getFlashdata('login');
$username = $session->getFlashdata('username');
$password = $session->getFlashdata('password');
$active = $session->getFlashdata('active');
?>

<section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-6">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5">
                        <form method="post" action="/valid_login">
                            <h3 class="text-center mb-5">Login</h3>
                            <div>
                                <?php if ($username) { ?>
                                    <p style="color:red"><?php echo $username ?></p>
                                <?php } ?>

                                <?php if ($password) { ?>
                                    <p style="color:red"><?php echo $password ?></p>
                                <?php } ?>
                                <?php if ($active) { ?>
                                    <p style="color:red"><?php echo $active ?></p>
                                <?php } ?>
                                <?php if ($login) { ?>
                                    <p style="color:green"><?php echo $login ?></p>
                                <?php } ?>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="text" name="username" placeholder="Username" class="form-control form-control-lg" required>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" placeholder="Password" name="password" class="form-control form-control-lg" required>
                            </div>

                            <p><b>Belum punya akun? </b><a href="/register">Silahkan klik disini untuk mendaftar.</a></p>

                            <button type="submit" name="login" class="btn btn-primary btn-lg btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
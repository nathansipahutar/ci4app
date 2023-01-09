<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?php
$session = session();
$error = $session->getFlashdata('error');
?>

<?php if ($error) { ?>
    <p style="color:red">Terjadi Kesalahan:
    <ul>
        <?php foreach ($error as $e) { ?>
            <li><?php echo $e ?></li>
        <?php } ?>
    </ul>
    </p>
<?php } ?>

<section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-6">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5">
                        <form method="post" action="/valid_register">
                            <h3 class="text-center mb-5">Registrasi</h3>

                            <div class="form-outline mb-4">
                                <input type="text" name="username" placeholder="Username" class="form-control form-control-lg" required>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="email" placeholder="Email" name="email" class="form-control form-control-lg" required>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="number" name="no_hp" placeholder="Nomor HP" class="form-control form-control-lg" required>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" placeholder="Password" name="password" class="form-control form-control-lg" required>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" placeholder="Konfirmasi Password" name="confirm" class="form-control form-control-lg" required>
                            </div>

                            <p><b>Sudah punya akun? </b><a href="/login">Silahkan klik disini untuk login.</a></p>

                            <button type="submit" name="login" class="btn btn-primary btn-lg btn-block">Registrasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>
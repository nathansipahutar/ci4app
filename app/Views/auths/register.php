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

<h5>Register</h5>
<form method="post" action="/valid_register">
    Username: <br>
    <input type="text" name="username" required><br>
    Email: <br>
    <input type="email" name="email" required><br>
    Nomor HP (Whatsapp): <br>
    <input type="number" name="no_hp" required><br>
    Password: <br>
    <input type="password" name="password" required><br>
    Konfirmasi Password: <br>
    <input type="password" name="confirm" required><br>
    <button type="submit" name="login">Register</button>
</form>
<p>
    <a href="/login">Sudah punya akun?</a>
</p>
<?= $this->endSection(); ?>
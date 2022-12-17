<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?php
$session = session();
$login = $session->getFlashdata('login');
$username = $session->getFlashdata('username');
$password = $session->getFlashdata('password');
$active = $session->getFlashdata('active');
?>

<h5>Login</h5>

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

<form method="post" action="/valid_login">
    Username: <br>
    <input type="text" name="username" required><br>
    Password: <br>
    <input type="password" name="password" required><br>
    <button type="submit" name="login">Login</button>
</form>
<p>
    <a href="/register">Belum punya akun?</a>
</p>
<?= $this->endSection(); ?>
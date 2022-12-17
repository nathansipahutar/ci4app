<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?= $i = 1; ?>
<div class="container">
    <div class="row">
        <?php foreach ($products_rajutan as $p) : ?>
            <div class="col-4">
                <div class="card text-center">
                    <div class="card-header">
                        <span class="text-success">
                            <strong><?= $p['nama']; ?></strong>
                        </span>
                    </div>
                    <div class="card-body">
                        <img src="/img/<?= $p['gambar']; ?>" alt="Products picture" class="img-thumbnail" style="max-width: 150px">
                        <h5 class="mt-3 text-success"><?= "Rp " .  $p['harga']; ?></h5>
                    </div>
                    <div class="card-footer">
                        <a style="width: 100%;" class="btn btn-success" href="/product/beli/<?= $p['slug']; ?>">Beli</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection(); ?>
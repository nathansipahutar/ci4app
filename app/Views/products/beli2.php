<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="beli-container container">
    <div class="form-beli-heading">
        <h2 class="text-center">Form Pemesanan produk</h2>
        <p class="text-center">Silahkan lengkapi form berikut untuk melakukan pemesanan produk</p>
    </div>
    <div class="form-pembelian2-responsive row">
        <div class="form-beli2 col-6">
            <div class="card">
                <div class="card-body">
                    <img src="/img/<?= $products['gambar'] ?>" alt="" class="img-fluid">
                    <h3 class="nama-product"><?= $products['nama'] = isset($products['nama']) ? $products['nama'] : ''; ?></h3>
                    <h4 class="harga-product">Rp <?= $products['harga'] = isset($products['harga']) ? $products['harga'] : ''; ?></h4>
                </div>
            </div>
        </div>
        <div class="form-beli2 col-6">
            <h4>Pembelian</h4>
            <form action="/products/saveJemput" method="post" enctype="multipart/form-data">
                <!-- crsf agar form hanya dapat diakses di halaman ini -->
                <?= csrf_field(); ?>
                <input hidden type="text" class="form-control" id="id_barang" name="id_barang" value="<?= $products['id_barang']; ?>">
                <input hidden type="text" class="form-control" id="slug" name="slug" value="<?= $products['slug']; ?>">
                <div class=" form-group row">
                    <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="jumlah" name="jumlah">
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="total_harga" class="col-sm-2 col-form-label">Total Harga</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="total_harga" name="total_harga">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 d-flex flex-end">
                        <button type="submit" class="btn btn-success ">Beli</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $('document').ready(function() {
        var jumlah_pembelian = 1;
        var harga = <?= $products['harga'] ?>;
        var ongkir = 0;

        $("#jumlah").on("change", function() {
            jumlah_pembelian = $("#jumlah").val();
            var total_harga = (jumlah_pembelian * harga) + ongkir;
            $("#total_harga").val(total_harga);
        });
    });
</script>
<?= $this->endSection(); ?>
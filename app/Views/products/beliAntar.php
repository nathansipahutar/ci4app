<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<?php

$id_barang = [
    'name' => 'id_barang',
    'id' => 'id_barang',
    'value' => $products['id_barang'],
    'type' => 'hidden'
];

$id_pelanggan = [
    'name' => 'id_pelanggan',
    'id' => 'id_pelanggan',
    'value' => session()->get('id'),
    'type' => 'hidden'
];

$jumlah = [
    'name' => 'jumlah',
    'id' => 'jumlah',
    'value' => 1,
    'min' => 1,
    'class' => 'form-control',
    'type' => 'number',
    // MAX SEBENERNYA GAPERLU
    // 'max' => $products['stok']
];
$total_harga = [
    'name' => 'total_harga',
    'id' => 'total_harga',
    'value' => null,
    'class' => 'form-control',
    'readonly' => true,
];

$ongkir = [
    'name' => 'ongkir',
    'id' => 'ongkir',
    'value' => null,
    'class' => 'form-control',
    'readonly' => true,
];

$alamat = [
    'name' => 'alamat',
    'id' => 'alamat',
    'class' => 'form-control',
    'value' => null,
];
$submit = [
    'name' => 'submit',
    'id' => 'submit',
    'type' => 'submit',
    'value' => 'Beli',
    'class' => 'btn btn-success',
];
?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <img src="/img/<?= $products['gambar'] ?>" alt="" class="img-fluid">
                    <h1 class="text-success"><?= $products['nama'] = isset($products['nama']) ? $products['nama'] : ''; ?></h1>
                    <h4>Harga : <?= $products['harga'] = isset($products['harga']) ? $products['harga'] : ''; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-6">
            <h4>Pengiriman</h4>
            <div class="form-group">
                <label for="provinsi">Pilih Provinsi</label>
                <select name="" id="provinsi" class="form-control">
                    <option value="">Select Provinsi</option>
                    <?php foreach ($provinsi as $pr) : ?>
                        <option value="<?= $pr->province_id ?>"><?= $pr->province ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label for="provinsi">Pilih Kabupaten/kota</label>
                <select name="" id="kabupaten" class="form-control">
                    <option value="">Select Kabupaten/kota</option>
                </select>
            </div>
            <div class="form-group">
                <label for="provinsi">Pilih Service</label>
                <select name="" id="service" class="form-control">
                    <option value="">Select Service</option>
                </select>
            </div>
            <strong>Estimasi : <span id="estimasi"></span></strong>

            <br>
            <?= form_open('Products/beli/snack_bouquet'); ?>
            <?= form_input($id_barang); ?>
            <?= form_input($id_pelanggan); ?>
            <div class="form-group">
                <?= form_label('Jumlah Pembelian', 'jumlah'); ?>
                <?= form_input($jumlah); ?>
            </div>
            <div class="form-group">
                <?= form_label('Ongkir', 'ongkir'); ?>
                <?= form_input($ongkir); ?>
            </div>
            <div class="form-group">
                <?= form_label('Total Harga', 'total_harga'); ?>
                <?= form_input($total_harga); ?>
            </div>
            <div class="form-group">
                <?= form_label('Alamat', 'alamat'); ?>
                <?= form_input($alamat); ?>
            </div>
            <div class="text-right">
                <?= form_submit($submit); ?>
            </div>
            <?= form_close(); ?>
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
        $("#provinsi").on('change', function() {
            $("#kabupaten").empty();
            var id_province = $(this).val();
            $.ajax({
                type: 'GET',
                url: "<?= site_url('product/getCity') ?>",
                data: {
                    'id_province': id_province,
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    var results = data["rajaongkir"]["results"];
                    for (var i = 0; i < results.length; i++) {
                        $("#kabupaten").append($('<option>', {
                            value: results[i]["city_id"],
                            text: results[i]["city_name"]
                        }));
                    }
                },
                error: function(err) {
                    console.log(err);
                },
            });
        });

        $("#kabupaten").on('change', function() {
            var id_city = $(this).val();
            $.ajax({
                type: 'GET',
                url: "<?= site_url('product/getCost') ?>",
                data: {
                    'origin': 153,
                    'destination': id_city,
                    'weight': 500,
                    'courier': 'jne',
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    var results = data["rajaongkir"]["results"][0]["costs"];
                    for (var i = 0; i < results.length; i++) {
                        var text = results[i]["description"] + "(" + results[i]["service"] + ")";
                        $("#service").append($('<option>', {
                            value: results[i]["cost"][0]["value"],
                            text: text,
                            etd: results[i]["cost"][0]["etd"]
                        }));
                    }
                },
                error: function(err) {
                    console.log(err);
                },
            });
        });

        $("#service").on('change', function() {
            var estimasi = $('option:selected', this).attr('etd');
            ongkir = parseInt($(this).val());
            $("#ongkir").val(ongkir);
            $("#estimasi").html(estimasi + " Hari");
            var total_harga = (jumlah_pembelian * harga) + ongkir;
            $("#total_harga").val(total_harga);
        });

        $("#jumlah").on("change", function() {
            jumlah_pembelian = $("#jumlah").val();
            var total_harga = (jumlah_pembelian * harga) + ongkir;
            $("#total_harga").val(total_harga);
        });
    });
</script>
<?= $this->endSection(); ?>
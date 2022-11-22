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

// $ongkir = [
//     'name' => 'ongkir',
//     'id' => 'ongkir',
//     'value' => null,
//     'class' => 'form-control',
//     'readonly' => true,
// ];

// $alamat = [
//     'name' => 'alamat',
//     'id' => 'alamat',
//     'class' => 'form-control',
//     'value' => null,
// ];
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

            <br>
            <?= form_open('Products/beli/jemput/' . $products['slug']); ?>
            <?= form_input($id_barang); ?>
            <?= form_input($id_pelanggan); ?>
            <div class="form-group">
                <?= form_label('Jumlah Pembelian', 'jumlah'); ?>
                <?= form_input($jumlah); ?>
            </div>
            <div class="form-group">
                <?= form_label('Total Harga', 'total_harga'); ?>
                <?= form_input($total_harga); ?>
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

        $("#jumlah").on("change", function() {
            jumlah_pembelian = $("#jumlah").val();
            var total_harga = (jumlah_pembelian * harga) + ongkir;
            $("#total_harga").val(total_harga);
        });
    });
</script>
<?= $this->endSection(); ?>
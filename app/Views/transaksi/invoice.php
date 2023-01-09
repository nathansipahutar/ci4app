<html>

<head>
    <title>Invoice</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid black;
            text-align: center;
        }
    </style>
</head>

<body>
    <div style="font-size: 64px; color: '#dddddd'"><i>Invoice</i></div>
    <p>
        <i>Bunch of Gifts Shop</i><br>
        Jakarta, Indonesia <br>
        08788923222
    </p>
    <hr>
    <hr>
    <p>

        Pembeli : <?= $transaksi->username; ?> <br>
        Alamat : <?= $transaksi->alamat; ?><br>
        Transaksi No : <?= $transaksi->id_transaksi; ?> <br>
        Tanggal : <?= date('Y-m-d', strtotime($transaksi->created_at)); ?>
    </p>

    <table cellpadding="10">
        <tr>
            <th><strong>Barang</strong></th>
            <th><strong>Harga Satuan</strong></th>
            <th><strong>Jumlah</strong></th>
            <th><strong>Ongkir</strong></th>
            <th><strong>Total Harga</strong></th>
        </tr>
        <tr>
            <td><?= $products['nama']; ?></td>
            <td><?= "Rp " .  $products['harga']; ?></td>
            <td><?= $transaksi->jumlah; ?></td>
            <td><?= "Rp " . $transaksi->ongkir; ?></td>
            <td><?= $transaksi->total_harga; ?></td>
        </tr>
    </table>
</body>

</html>
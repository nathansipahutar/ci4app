<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<a href="/admin/laporan">BACK</a>
<div class='container' style='margin-top: 20px;'>

    <!-- Search form -->
    <form method='get' action="laporan" id="searchForm">
        <input type='date' name='dari' value='<?= $dari ?>'>
        <input type='date' name='ke' value='<?= $ke ?>'>
        <input type='button' id='btnsearch' value='Submit' onclick='document.getElementById("searchForm").submit();'>
    </form>
    <br />

    <div class="card">
        <div class="card-body">
            <table class="table table-hover" border='1' style='border-collapse: collapse;'>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Produk</th>
                        <th>Pembeli</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1 + (10 * ($currentPage - 1));
                    foreach ($transaksi as $transaksi) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $transaksi->id_transaksi . "</td>";
                        echo "<td>" . $transaksi->nama . "</td>";
                        echo "<td>" . $transaksi->username . "</td>";
                        echo "<td>" . $transaksi->total_harga . "</td>";
                        echo "<td>" . $transaksi->status . "</td>";
                        echo "<td>" . $transaksi->created_at . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginate -->
    <div style='margin-top: 10px;'>
        <?= $pager->links() ?>
    </div>

</div>
<?= $this->endSection('page-content'); ?>
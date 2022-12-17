<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ADMIN</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Lihat User List -->
        <div class="row">
            <div class="col-lg-8">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><?= $user->username; ?></td>
                                <td><?= $user->email; ?></td>
                                <td><?= $user->no_hp; ?></td>
                                <td>
                                    <a href="<?= base_url('admin/' . $user->userid); ?>" class="btn btn-info">Detail</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mb-5 mt-5" id="pie-chart" style="height: 400px; width: 100%"></div>
        <div class="mb-5 mt-5">
            <div id="GoogleLineChart" style="height: 400px; width: 100%"></div>
        </div>
        <div class="mb-5">
            <div id="GoogleBarChart" style="height: 400px; width: 100%"></div>
        </div>

        <!-- Color System -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        Primary
                        <div class="text-white-50 small">#4e73df</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        Success
                        <div class="text-white-50 small">#1cc88a</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-info text-white shadow">
                    <div class="card-body">
                        Info
                        <div class="text-white-50 small">#36b9cc</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                        Warning
                        <div class="text-white-50 small">#f6c23e</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                        Danger
                        <div class="text-white-50 small">#e74a3b</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-secondary text-white shadow">
                    <div class="card-body">
                        Secondary
                        <div class="text-white-50 small">#858796</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-light text-black shadow">
                    <div class="card-body">
                        Light
                        <div class="text-black-50 small">#f8f9fc</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body">
                        Dark
                        <div class="text-white-50 small">#5a5c69</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    const init = () => {
        pieChart.chart = new google.visualization.PieChart(
            document.querySelector(pieChart.element)
        );
        pieChart.chart.draw(
            google.visualization.arrayToDataTable(pieChart.data),
            pieChart.options
        );

        google.charts.setOnLoadCallback(drawLineChart);
        google.charts.setOnLoadCallback(drawBarChart);

    };

    google.charts.load('current', {
        packages: ['corechart'],
        callback: init
    });


    //Pie Chart
    const pieChart = {
        chart: null,
        data: [
            ['Kategori', 'Jumlah Pembelian'],
            ['Snack Bouquet', <?= $pie_snack; ?>],
            ['Rajutan', <?= $pie_rajutan; ?>]
        ],
        element: '#pie-chart',
        options: {
            title: 'Total Transaksi per Kategori',

        }
    };

    // google.charts.setOnLoadCallback(drawLineChart);
    // Line Chart
    function drawLineChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year', 'Total Transaksi '],
            <?php
            foreach ($years as $row) {
                echo "['" . $row['year'] . "'," . $row['id_transaksi'] . "],";
            } ?>
        ]);
        var options = {
            title: 'Total Transaksi Per Tahun',
            curveType: 'function',
            legend: {
                position: 'top'
            }
        };
        var chart = new google.visualization.LineChart(document.getElementById('GoogleLineChart'));
        chart.draw(data, options);
    }


    // Bar Chart
    // google.charts.setOnLoadCallback(showBarChart);

    function drawBarChart() {
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Total Transaksi  '],
            <?php
            foreach ($months as $row) {
                echo "['" . $row['month'] . "'," . $row['id_transaksi'] . "],";
            }
            ?>
        ]);
        var options = {
            title: ' Total transaksi per bulan di tahun <?= date('Y'); ?>',
            is3D: true,
        };
        var chart = new google.visualization.BarChart(document.getElementById('GoogleBarChart'));
        chart.draw(data, options);
    }
</script>

<?= $this->endSection(); ?>
<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h1>Lacak Resi</h1>
<h2>test</h2>

<p><?= $transaksi->kode_resi; ?></p>
<div class="row" id="resi_status"></div>
<div class="row" id="resi_posisi"></div>
<div class="row" id="resi_result"></div>
<!-- <div class="col-md-8">
    <h1>STATUS PENGIRIMAN</h1>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="row">STATUS</th>
                <td>`+ resi.summary.status +`</td>
            </tr>
            <tr>
                <th scope="row">LAYANAN</th>
                <td>`+ resi.summary.service +`</td>
            </tr>
            <tr>
                <th scope="row">PENGIRIM</th>
                <td>`+ resi.detail.shipper +`</td>
            </tr>
            <tr>
                <th scope="row">ASAL</th>
                <td>`+ resi.detail.origin +`</td>
            </tr>
            <tr>
                <th scope="row">PENERIMA</th>
                <td>`+ resi.detail.receiver +`</td>
            </tr>
            <tr>
                <th scope="row">TUJUAN</th>
                <td>`+ resi.detail.destination +`</td>
            </tr>
        </tbody>
    </table>
</div> -->

<!-- <div class="col">
    <h1 class="text-center">` + result.message +`</h1>
</div> -->

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $('document').ready(function() {
        let kode_resi = '<?= $transaksi->kode_resi; ?>';
        $.ajax({
            url: 'https://api.binderbyte.com/v1/track?api_key=83f5c1ec842782e1bc44c4763ccd7d1685a97a75fce1a08f40c967506188914f',
            type: 'get',
            dataType: 'json',
            data: {
                'courier': 'jne',
                'awb': kode_resi
            },

            success: function(result) {
                if (result.status == 200) {
                    let resi = result.data;
                    console.log(resi);
                    $('#resi_status').html(`
                        <div class="col-md-8">
                            <h1>STATUS PENGIRIMAN</h1>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th scope="row">STATUS</th>
                                        <td>` + resi.summary.status + `</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">LAYANAN</th>
                                        <td>` + resi.summary.service + `</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">PENGIRIM</th>
                                        <td>` + resi.detail.shipper + `</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">ASAL</th>
                                        <td>` + resi.detail.origin + `</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">PENERIMA</th>
                                        <td>` + resi.detail.receiver + `</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">TUJUAN</th>
                                        <td>` + resi.detail.destination + `</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    `);
                    var lacakPosisi = '';
                    for (let i = 0; i < resi.history.length; i++) {
                        lacakPosisi +=
                            `<tbody>
                                <tr>
                                    <th scope="row">DATE</th>
                                    <td>` + resi.history[i].date + `</td>
                                </tr>
                                <tr>
                                    <th scope="row">DESC</th>
                                    <td>` + resi.history[i].desc + `</td>
                                </tr>
                                <tr>
                                    <th scope="row">LOCATION</th>
                                    <td>` + resi.history[i].location + `</td>
                                </tr>
                            </tbody>`
                    }

                    $('#resi_posisi').html(`
                    <table class="table table-bordered">${lacakPosisi}
                    </table>
                    `);
                } else {
                    $('#resi_result').html(`
                        <div class="col">
                            <h1 class="text-center">SALAH WOY</h1>
                        </div>
                    `)
                }
            }
        });
    });
</script>
<?= $this->endSection(); ?>
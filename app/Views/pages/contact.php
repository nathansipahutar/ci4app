<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<section id="contact" class="contact">

    <div class="container" data-aos="fade-up" data-aos-duration="1200">

        <div class="contact-heading section-header">
            <h2 class="text-center">Hubungi Kami</h2>
        </div>

        <div class="row gy-4">

            <div class="col-lg-6">

                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="info-box">
                            <i class="fa-solid fa-location-dot"></i>
                            <h3>Alamat</h3>
                            <p>Jl. Lebak Bulus III no. 28 <br>Cilandak, Jakarta Selatan</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <i class="fa-solid fa-phone"></i>
                            <h3>Telepon kami</h3>
                            <p>(+62) 877-6327-3047</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <i class="fa-solid fa-envelope"></i>
                            <h3>Email Kami</h3>
                            <p>bunchofgift.id@gmail.com</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <i class="fa-brands fa-whatsapp"></i>
                            <h3>Whatsapp</h3>
                            <p>Silahkan hubungi kami melalui link berikut ini. <b><a href="https://wa.me/+6287763273047">Klik disini!</a></b></p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="maps col-lg-6">
                <iframe class="maps-frame" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.70927967415!2d106.78914841529573!3d-6.301877663431043!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ee205863d129%3A0x88e26998d64ab4a9!2sJl.%20Lb.%20Bulus%20III%20No.28%2C%20RT.9%2FRW.7%2C%20Cilandak%20Bar.%2C%20Kec.%20Cilandak%2C%20Kota%20Jakarta%20Selatan%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2012450!5e0!3m2!1sid!2sid!4v1671773224209!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

        </div>

    </div>

</section>
<?= $this->endSection(); ?>
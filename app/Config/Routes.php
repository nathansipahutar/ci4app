<?php

namespace Config;

use App\Controllers\Products;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Pages::index');
$routes->get('/pages/home', 'Pages::index');
$routes->get('/pages/about', 'Pages::about');
$routes->get('/pages/contact', 'Pages::contact');

$routes->get('/products', 'Products::index');
$routes->get('/products/create', 'Products::create');

$routes->post('/products/save', 'Products::save');


$routes->get('/products/(:segment)', 'Products::detail/$1');

//CARA DELETE DENGAN KONVENSIONAL
$routes->get('/products/delete/(:segment)', 'Products::delete/$1');

//CARA DELETE LEBIH KEREN
$routes->delete('/products/(:num)', 'Products::delete/$1');

//EDIT
$routes->get('/product/edit/(:segment)', 'Products::edit/$1');

//UPDATE
$routes->post('/product/update/(:segment)', 'Products::update/$1');


//PAGE ORANG
$routes->get('/orang', 'Orang::index');

//LOGIN
$routes->get('/login', 'Auth::login');
$routes->post('/valid_login', 'Auth::valid_login');
$routes->get('/register', 'Auth::register');
$routes->post('/valid_register', 'Auth::valid_register');
$routes->get('/emailValidation/(:segment)', 'Auth::emailValidation/$1');
$routes->get('/logout', 'Auth::logout');
//PRODUCTS
$routes->get('/product/snack', 'Products::snack');
$routes->get('/product/rajutan', 'Products::rajutan');

//LOGIN FINAL
// $routes->get('/auths/login', 'Auth::login');
// $routes->post('/auths/valid_login', 'Auth::valid_login');
// $routes->get('/auths/register', 'Auth::register');
// $routes->post('/auths/valid_register', 'Auth::valid_register');
// $routes->get('/auths/logout', 'Auth::logout');

//APABILA LOGIN SEBAGAI ADMIN. tambah routes baru kalau ada page lain
$routes->get('/admin', 'Admin::index');
$routes->get('/admin/index', 'Admin::index');
$routes->get('/admin/(:num)', 'Admin::detail/$1');
$routes->get('/admin/products', 'Admin::products');

//APABILA LOGIN SEBAGAI USER. tambah routes baru kalau ada page lain
$routes->get('/user', 'User::index');
$routes->get('/user/edit', 'User::edit');
$routes->post('/user/update/(:segment)', 'User::update/$1');


//REGISTER
$routes->get('/register', 'Pages::register');

//EDIT PROFILE
$routes->get('/register', 'Pages::register');
$routes->post('/register', 'Pages::registerUser');

//HOME USER
// $routes->get('/coba', function () {
//     echo 'Halo';
// });

//TRANSAKSI
$routes->get('/product/beli/(:segment)', 'Products::beli/$1');
$routes->post('/Products/beli/(:segment)', 'Products::beli/$1');
$routes->get('/product/beli2/(:segment)', 'Products::beli2/$1');
$routes->post('/Products/beli2/(:segment)', 'Products::beli2/$1');
$routes->post('/products/saveJemput', 'Products::saveJemput');

$routes->get('/product/beli/jemput/(:segment)', 'Products::beliJemput/$1');
$routes->post('/Products/beli/jemput/(:segment)', 'Products::beliJemput/$1');
$routes->get('/product/beli/antar/(:segment)', 'Products::beliAntar/$1');
$routes->post('/Products/beli/antar/(:segment)', 'Products::beliAntar/$1');
$routes->get('/transaksi/view/(:num)', 'Transaksi::view/$1');
$routes->post('transaksi/update/(:num)', 'Transaksi::update/$1');
//CEK TRANSAKSI UNTUK ADMIN
$routes->get('/transaksi/index', 'Transaksi::index');
$routes->get('/transaksi/sendEmail', 'Transaksi::sendEmail');
$routes->get('/transaksi/invoice/(:num)', 'Transaksi::invoice');
$routes->get('/transaksi/lacakResi/(:num)', 'Transaksi::lacakResi');

//TRANSAKSI PELANGGAN
$routes->get('/transaksi/user', 'Transaksi::user');
$routes->delete('/transaksi/(:num)', 'Transaksi::delete/$1');

//PELANGGAN BAYAR
$routes->get('/transaksi/bayar/(:num)', 'Transaksi::bayar/$1');
$routes->post('/transaksi/submitBayar/(:num)', 'Transaksi::submitBayar/$1');

//--ADMIN--
//EDIT PESANAN
$routes->get('/admin/transaksi/inputResi/(:segment)', 'Admin::inputResi/$1');
$routes->post('/admin/transaksi/simpanResi/(:segment)', 'Admin::simpanResi/$1');
//CEK PEMBAYARAN
$routes->get('/admin/cekPembayaran/(:num)', 'Admin::cekPembayaran/$1');
$routes->post('/admin/prosesProduk/(:num)', 'Admin::prosesProduk/$1');

//COBA PAGINATE LAPORAN
$routes->get('/admin/laporan', 'Admin::laporan');

//LAPORAN PENJUALAN
// $routes->get('admin/laporan', 'Admin::laporan');
// $routes->post('admin/laporan', 'Admin::laporan');
$routes->get('admin/cobaLaporan', 'Admin::cobaLaporan');
$routes->post('admin/cobaLaporan', 'Admin::cobaLaporan');
// $routes->get('/admin/laporanPenjualan', 'Admin::laporanPenjualan');
// $routes->post('/admin/laporanPenjualan', 'Admin::filterLaporanPenjualan');

//SEND EMAIL INVOICE
$routes->get('/product/getCost', 'Products::getCost');

//API
$routes->get('/product/getCity', 'Products::getCity');
//getCOST
$routes->get('/product/getCost', 'Products::getCost');

//ADMIN GRAFIK
$routes->match(['get', 'post'], 'admin/chart', 'Admin::chart');





/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

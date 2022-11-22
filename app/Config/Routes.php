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
$routes->get('/login', 'Pages::login');

//APABILA LOGIN SEBAGAI ADMIN. tambah routes baru kalau ada page lain
$routes->get('/admin', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/index', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/(:num)', 'Admin::detail/$1', ['filter' => 'role:admin']);
$routes->get('/admin/products', 'Admin::products', ['filter' => 'role:admin']);

//APABILA LOGIN SEBAGAI USER. tambah routes baru kalau ada page lain
$routes->get('/user', 'User::index', ['filter' => 'role:user']);
$routes->get('/user/index', 'User::index', ['filter' => 'role:user']);

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

$routes->get('/product/beli/jemput/(:segment)', 'Products::beliJemput/$1');
$routes->get('/product/beli/antar/(:segment)', 'Products::beliAntar/$1');
$routes->post('/Products/beli/jemput/(:segment)', 'Products::beliJemput/$1');
$routes->post('/Products/beli/antar/(:segment)', 'Products::beliAntar/$1');
$routes->get('/transaksi/view/(:num)', 'Transaksi::view/$1');
$routes->get('/transaksi/index', 'Transaksi::index');
$routes->get('/transaksi/sendEmail', 'Transaksi::sendEmail');
$routes->get('/transaksi/invoice/(:num)', 'Transaksi::invoice');
$routes->get('/transaksi/lacakResi/(:num)', 'Transaksi::lacakResi');
$routes->get('/transaksi/user', 'Transaksi::user');

//--ADMIN--
//EDIT PESANAN
$routes->get('/admin/transaksi/edit/(:segment)', 'Admin::edit/$1');
//UPDATE PESANAN
$routes->post('/admin/transaksi/update/(:segment)', 'Admin::update/$1');

//LAPORAN PENJUALAN
$routes->get('/admin/laporanPenjualan', 'Admin::laporanPenjualan');
$routes->post('/admin/laporanPenjualan', 'Admin::filterLaporanPenjualan');

//SEND EMAIL INVOICE
$routes->get('/product/getCost', 'Products::getCost');

//API
$routes->get('/product/getCity', 'Products::getCity');
//getCOST
$routes->get('/product/getCost', 'Products::getCost');

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

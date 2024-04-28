<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// auth
$routes->get('/', 'Login::index');
$routes->post('/auth', 'Login::ceklogin');
$routes->get('/keluar', 'Login::keluar');
$routes->get('/alert', 'Login::alert');

// dashboard
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

// profil
$routes->post('/ubah-profil', 'Profil::update', ['filter' => 'auth']);

// registrasi
$routes->get('/registrasi', 'Registrasi::index', ['filter' => 'auth']);
$routes->post('/tambah-order', 'Registrasi::save', ['filter' => 'auth']);
$routes->post('/list-paket', 'Registrasi::listPaket', ['filter' => 'auth']);

// only admin-owner page
$routes->group('', ['filter' => ['role', 'auth']], static function ($routes) {
    // pelanggan
    $routes->get('/pelanggan', 'Pelanggan::index');
    $routes->post('/tambah-pelanggan', 'Pelanggan::save');
    $routes->post('/ubah-pelanggan', 'Pelanggan::update');
    $routes->get('/hapus-pelanggan/(:num)', 'Pelanggan::delete/$1');
    $routes->get('/filter-pelanggan', 'Pelanggan::filter');
    $routes->get('/laporan-pelanggan', 'Pelanggan::pdf');

    // pengguna
    $routes->get('/pengguna', 'Pengguna::index');
    $routes->post('/tambah-pengguna', 'Pengguna::save');
    $routes->post('/ubah-pengguna', 'Pengguna::update');
    $routes->get('/hapus-pengguna/(:num)', 'Pengguna::delete/$1');
    $routes->get('/filter-pengguna', 'Pengguna::filter');
    $routes->get('/laporan-pengguna', 'Pengguna::pdf');

    // paket
    $routes->get('/paket', 'Paket::index');
    $routes->post('/tambah-paket', 'Paket::save');
    $routes->post('/ubah-paket', 'Paket::update');
    $routes->get('/hapus-paket/(:num)', 'Paket::delete/$1');
    $routes->get('/filter-paket', 'Paket::filter');
    $routes->get('/laporan-paket', 'Paket::pdf');

    // bahan
    $routes->get('/bahan', 'Bahan::index');
    $routes->post('/tambah-bahan', 'Bahan::save');
    $routes->post('/ubah-bahan', 'Bahan::update');
    $routes->get('/hapus-bahan/(:num)', 'Bahan::delete/$1');
    $routes->get('/laporan-bahan', 'Bahan::pdf');
});

// transaksi
$routes->get('/transaksi', 'Transaksi::index', ['filter' => 'auth']);
$routes->get('/detail-transaksi', 'Transaksi::detail', ['filter' => 'auth']);
$routes->post('/ubah-transaksi', 'Transaksi::update', ['filter' => 'auth']);
$routes->get('/hapus-transaksi/(:num)', 'Transaksi::delete/$1', ['filter' => 'auth']);
$routes->get('/tambah-paket-transaksi/(:num)/(:num)', 'Transaksi::add_paket/$1/$2', ['filter' => 'auth']);
$routes->get('/hapus-paket-transaksi/(:num)/(:num)/(:num)', 'Transaksi::delete_paket/$1/$2/$3', ['filter' => 'auth']);
$routes->get('/tambah-bahan-transaksi/(:num)/(:num)', 'Transaksi::add_bahan/$1/$2', ['filter' => 'auth']);
$routes->get('/hapus-bahan-transaksi/(:num)/(:num)/(:num)', 'Transaksi::delete_bahan/$1/$2/$3', ['filter' => 'auth']);
$routes->get('/nota', 'Transaksi::nota', ['filter' => 'auth']);
$routes->get('/filter-transaksi', 'Transaksi::filter', ['filter' => 'auth']);
$routes->post('/tanggal-filter-transaksi', 'Transaksi::getDataFilter', ['filter' => 'auth']);
$routes->get('/laporan-transaksi', 'Transaksi::pdf', ['filter' => 'auth']);

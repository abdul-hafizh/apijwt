<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// REST API ANDROID
$route['api/login']['POST'] = 'ApiMaster/login';

// GET
$route['api/admin']['GET'] = 'ApiMaster/admin';
$route['api/kategori']['GET'] = 'ApiMaster/kategori';
$route['api/manga']['GET'] = 'ApiMaster/manga';
$route['api/most-viewed']['GET'] = 'ApiMaster/most_viewed';
$route['api/latest-release']['GET'] = 'ApiMaster/latest_release';
$route['api/tampilmost']['GET'] = 'ApiMaster/tampilmostkanan';
$route['api/tampillates']['GET'] = 'ApiMaster/tampillateskanan';
$route['api/chapter']['GET'] = 'ApiMaster/chapter';
$route['api/detail-kategori/(:any)']['GET'] = 'ApiMaster/detail_kategori/$1';
$route['api/detail-manga/(:any)']['GET'] = 'ApiMaster/detail_manga/$1';
$route['api/detail-chapter/(:any)']['GET'] = 'ApiMaster/detail_chapter/$1';
$route['api/detail/(:any)']['GET'] = 'ApiMaster/detail/$1';

// POST
$route['api/tambah-kategori']['POST'] = 'ApiMaster/tambah_kategori';
$route['api/tambah-manga']['POST'] = 'ApiMaster/tambah_manga';
$route['api/tambah-chapter']['POST'] = 'ApiMaster/tambah_chapter';
$route['api/tambah-detail']['POST'] = 'ApiMaster/tambah_detail';

// PUT
$route['api/update-kategori/(:any)']['PUT'] = 'ApiMaster/update_kategori/$1';
$route['api/update-manga/(:any)']['PUT'] = 'ApiMaster/update_manga/$1';
$route['api/update-chapter/(:any)']['PUT'] = 'ApiMaster/update_chapter/$1';

// DELETE
$route['api/hapus-kategori/(:any)']['DELETE'] = 'ApiMaster/hapus_kategori/$1';
$route['api/hapus-manga/(:any)']['DELETE'] = 'ApiMaster/hapus_manga/$1';
$route['api/hapus-chapter/(:any)']['DELETE'] = 'ApiMaster/hapus_chapter/$1';
$route['api/hapus-detail/(:any)']['DELETE'] = 'ApiMaster/hapus_detail/$1';

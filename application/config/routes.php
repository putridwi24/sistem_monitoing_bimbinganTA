<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes with
| underscores in the controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// >>>>> BERANDA
$route['dosen/beranda'] = 'beranda';
$route['mahasiswa/beranda'] = 'beranda';
$route['beranda'] = 'beranda';

// >>>>> AUTH
// login
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
// register
$route['register'] = 'auth/register';
// lupa password
$route['lupa_password'] = 'auth/password_forgot';
// email confirm
$route['email_confirm'] = 'auth/email_confirm';
// password reset
$route['password_reset'] = 'user/password_reset';
// <<<<< AUTH

// >>>>> user
$route['profile'] = 'user/index';
$route['profile/edit'] = 'user/edit';
$route['profile/password'] = 'user/password_change';
$route['avatar/update'] = 'user/update_avatar';
// <<<<< user

// >>>>> dosen
$route['dashboard'] = 'beranda/tim_ta';
$route['dosen'] = 'dosen/index';
$route['dosen/(:num)'] = 'dosen/show/$1';
$route['dosen/import'] = 'dosen/import';
$route['dosen/import/format'] = 'dosen/import_file_template';
$route['dosen/(:num)/delete'] = 'dosen/delete/$1';
// <<<<< dosen

// >>>>> mahasiswa
$route['mahasiswa'] = 'mahasiswa/index';
$route['mahasiswa/all'] = 'mahasiswa/index_tim_ta';
$route['mahasiswa/(:num)'] = 'mahasiswa/show/$1';
$route['mahasiswa/(:num)/dosbing/update'] = 'mahasiswa/update_dosbing/$1';
$route['mahasiswa/import'] = 'mahasiswa/import';
$route['mahasiswa/import/format'] = 'mahasiswa/import_file_template';
$route['mahasiswa/(:num)/delete'] = 'mahasiswa/delete/$1';
// <<<<< mahasiswa

// >>>>> pengumuman
// >> read
$route['pengumuman/all'] = 'pengumuman/index_public';
$route['pengumuman'] = 'pengumuman/index';
$route['pengumuman/(:num)'] = 'pengumuman/show/$1';
// >> create
$route['pengumuman/create'] = 'pengumuman/create';
// >> update
$route['pengumuman/(:num)/edit'] = 'pengumuman/edit/$1';
$route['pengumuman/publish']['post'] = 'pengumuman/publish';
$route['pengumuman/unpublish']['post'] = 'pengumuman/unpublish';
$route['pengumuman/file/delete']['post'] = 'pengumuman/delete_file';
$route['pengumuman/file/add']['post'] = 'pengumuman/add_file';
$route['pengumuman/archieve']['post'] = 'pengumuman/add_read_by';
// >> delete
$route['pengumuman/delete']['post'] = 'pengumuman/delete';
// <<<<< pengumuman

// >>>>> permohonan
$route['permohonan'] = 'permohonan/index';
$route['permohonan/(:num)'] = 'permohonan/show/$1';
$route['permohonan/create'] = 'permohonan/create';
$route['permohonan/accept'] = 'permohonan/accept';
$route['permohonan/reject'] = 'permohonan/reject';
$route['permohonan/cancel'] = 'permohonan/delete';
// <<<<< permohonan

// >>>>> bimbingan
$route['bimbingan'] = 'bimbingan/index';
$route['bimbingan/(:num)/process'] = 'bimbingan/process/$1';
// <<<<< bimbingan

// >>>>> timeline
$route['timeline'] = 'timeline/index';
$route['timeline/(:num)'] = 'timeline/show/$1';
$route['dosen/timeline/update']['post'] = 'dosen/timeline/update';
// <<<<< timeline

// >>>>> kartu kendali
$route['kartu_kendali'] = 'kartu_kendali/index';
$route['kartu_kendali/create'] = 'kartu_kendali/create';
$route['kartu_kendali/(:num)'] = 'kartu_kendali/show/$1';
$route['kartu_kendali/(:num)/edit'] = 'kartu_kendali/edit_mahasiswa/$1';
$route['kartu_kendali/sign/request']['post'] = 'kartu_kendali/sign_request';
$route['kartu_kendali/sign']['post'] = 'kartu_kendali/sign';
// <<<<< kartu kendali

// >>>>>> dokumen 
$route['dokumen'] = 'file/dokumen';
$route['dokumen/all'] = 'file/index_tim_ta';
$route['dokumen/add'] = 'file/create';
$route['dokumen/delete'] = 'file/delete';
// <<<<<< dokumen

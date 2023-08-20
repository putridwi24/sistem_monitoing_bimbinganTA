<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       https://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       https://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code



// my constants
// DATABASE  
defined('TABEL_USER') or define('TABEL_USER', 'users');
defined('TABEL_EMAIL_CONFIRM') or define('TABEL_EMAIL_CONFIRM', 'email_confirms');
defined('TABEL_PASSWORD_RESET') or define('TABEL_PASSWORD_RESET', 'password_resets');
defined('TABEL_USER_ROLE') or define('TABEL_USER_ROLE', 'register_user_roles');
defined('TABEL_MAHASISWA') or define('TABEL_MAHASISWA', 'mahasiswas');
defined('TABEL_DOSEN') or define('TABEL_DOSEN', 'dosens');
defined('TABEL_PENGUMUMAN') or define('TABEL_PENGUMUMAN', 'pengumumans');
defined('TABEL_PERMOHONAN') or define('TABEL_PERMOHONAN', 'permohonans');
defined('TABEL_BIMBINGAN') or define('TABEL_BIMBINGAN', 'bimbingans');
defined('TABEL_KARTU_KENDALI') or define('TABEL_KARTU_KENDALI', 'kartu_kendalis');
defined('TABEL_REGISTER_STATUS') or define('TABEL_REGISTER_STATUS', 'register_statuses');
defined('TABEL_REGISTER_STAGE') or define('TABEL_REGISTER_STAGE', 'register_stages');
defined('TABEL_PROGRES') or define('TABEL_PROGRES', 'progres');
defined('TABEL_FILES') or define('TABEL_FILES', 'files');

defined('PROGRES_STATUS_INIT') or define('PROGRES_STATUS_INIT', 'init');
defined('PROGRES_STATUS_PROSES') or define('PROGRES_STATUS_PROSES', 'proses');
defined('PROGRES_STATUS_REVISI') or define('PROGRES_STATUS_REVISI', 'revisi');
defined('PROGRES_STATUS_SELESAI') or define('PROGRES_STATUS_SELESAI', 'selesai');


// konfigurasi database
if (is_file(FCPATH . 'konfigurasi.php')) {
	require(FCPATH . 'konfigurasi.php');
} else {
	defined('BASE_URL') or define('BASE_URL', '	http://localhost:8080');
	defined('DB_HOSTNAME') or define('DB_HOSTNAME', 'localhost');
	defined('DB_USERNAME') or define('DB_USERNAME', 'root');
	defined('DB_PASSWORD') or define('DB_PASSWORD', '');
	defined('DB_NAME') or define('DB_NAME', 'sistem_monitoring_ta');
	defined('ENABLE_EMAIL') or define('ENABLE_EMAIL', true);
}
defined('SIMOTA_PASSWORD_DEFAULT') or define('SIMOTA_PASSWORD_DEFAULT', 'password');
defined('SIMOTA_AVATAR_DEFAULT') or define('SIMOTA_AVATAR_DEFAULT', 'default.png');


// konfigurasi email
defined('ENABLE_EMAIL') or define('ENABLE_EMAIL', false);
defined('MAIL_NOREPLY') or define('MAIL_NOREPLY', 'noreply@monitoring.itera.ac.id');
defined('MAIL_SMTP_HOST') or define('MAIL_SMTP_HOST', 'smtp.gmail.com');
defined('MAIL_SMTP_USER') or define('MAIL_SMTP_USER', 'putri.119140068@student.itera.ac.id');
defined('MAIL_SMTP_PASS') or define('MAIL_SMTP_PASS', 'put986532');
defined('MAIL_SMTP_CRYPTO') or define('MAIL_SMTP_CRYPTO', 'ssl');
defined('MAIL_SMTP_PORT') or define('MAIL_SMTP_PORT', '465');


// storage
defined('UPLOAD_PATH_PROFILE') or define('UPLOAD_PATH_PROFILE', FCPATH . '/storage/uploads/avatars/');
defined('AVATAR_URL') or define('AVATAR_URL', '/storage/uploads/avatars/');
defined('UPLOAD_PATH_NOTIFICATION') or define('UPLOAD_PATH_NOTIFICATION', FCPATH . '/storage/uploads/notifications/');
defined('ATTACHMENT_URL') or define('ATTACHMENT_URL', '/storage/uploads/notifications/');
defined('UPLOAD_PATH_BIMBINGAN') or define('UPLOAD_PATH_BIMBINGAN', FCPATH . '/storage/uploads/bimbingans/');
defined('URL_BIMBINGAN_ATTACHMENT') or define('URL_BIMBINGAN_ATTACHMENT', '/storage/uploads/bimbingans/');
defined('UPLOAD_PATH_TMP') or define('UPLOAD_PATH_TMP', FCPATH . '/storage/tmp/');

defined('UPLOAD_PATH_DOCUMENTS') or define('UPLOAD_PATH_DOCUMENTS', FCPATH . '/storage/uploads/documents/');
defined('URL_DOCUMENTS') or define('URL_DOCUMENTS', '/storage/uploads/documents/');

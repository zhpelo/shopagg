<?php

######################################################################
## Files and Directories #############################################
######################################################################

define('BACKEND_ALIAS', 'admin');

// File System
define('DOCUMENT_ROOT',      rtrim(str_replace('\\', '/', realpath(!empty($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : __DIR__ . '/..')), '/'));

define('FS_DIR_APP',         rtrim(str_replace('\\', '/', realpath(__DIR__ . '/..')), '/') . '/');
define('FS_DIR_STORAGE',     FS_DIR_APP);
define('FS_DIR_ADMIN',       FS_DIR_APP . BACKEND_ALIAS . '/');

// Web System
define('WS_DIR_APP',         preg_replace('#^' . preg_quote(DOCUMENT_ROOT, '#') . '#', '', FS_DIR_APP));
define('WS_DIR_STORAGE',     WS_DIR_APP);
define('WS_DIR_ADMIN',       WS_DIR_APP . BACKEND_ALIAS . '/');

######################################################################
## Database ##########################################################
######################################################################

// Database
define('DB_TYPE', 'mysql');
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'local');
define('DB_TABLE_PREFIX', 'lc_');
define('DB_CONNECTION_CHARSET', 'utf8');

######################################################################
## Application #######################################################
######################################################################

// Errors
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', FS_DIR_STORAGE . 'logs/errors.log');
ini_set('display_startup_errors', 'Off');
ini_set('display_errors', 'Off');
if (!isset($_SERVER['REMOTE_ADDR']) || in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '127.0.0.1'])) {
    ini_set('display_startup_errors', 'On');
    ini_set('display_errors', 'On');
}

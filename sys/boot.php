<?php

function check_for_error() {
    $error = error_get_last();
    if ($error) {
        $str = str_replace("\n", '<br>', $error["message"]);
        trigger_error($str, E_USER_ERROR);
    }
}

register_shutdown_function("check_for_error");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


define('BASE_PATH', realpath(__DIR__ . "/..") . DIRECTORY_SEPARATOR);
define('SYS_FUNCS', realpath(__DIR__ . "/funcs") . DIRECTORY_SEPARATOR);
define('SYS_CLASSES', realpath(__DIR__ . "/classes") . DIRECTORY_SEPARATOR);
define('APP', realpath(BASE_PATH . "/app") . DIRECTORY_SEPARATOR);
define('PUBLIC_PATH', realpath(BASE_PATH . "/public") . DIRECTORY_SEPARATOR);

session_start();

require_once SYS_FUNCS . 'utils.php';
require_once SYS_FUNCS . 'debug.php';
require_once APP . 'config.php';
require_once SYS_CLASSES . 'View.php';
require_once SYS_CLASSES . 'Dispatcher.php';
require_once SYS_CLASSES . 'Flash.php';
require_once SYS_CLASSES . 'Auth.php';
require_once SYS_CLASSES . 'URL.php';
require_once SYS_CLASSES . 'Upload.php';
require_once SYS_CLASSES . 'BDService.php';

Dispatcher::instance()->execute();

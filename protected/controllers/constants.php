<?php

$PRODUCT_NAME = "Mobi App";
$development = file_exists(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "development");
$HOST_NAME = "localhost";
if (FALSE):
    ini_set("display_errors",1);
    error_reporting(E_ALL);
    $WEB_URL = 'http://' . $_SERVER['HTTP_HOST'] . '/mobiapp/';
    $DOCUMENT_PATH = $_SERVER['DOCUMENT_ROOT'] . '/mobiapp/';

    $DB_USERNAME = "root";
    //$DB_PASSWORD = "";
    $DB_PASSWORD = "root";
    $DB_NAME = "mobiapp";
else:
    $WEB_URL = 'http://' . $_SERVER['HTTP_HOST'] . '/mobiapp/';
    $DOCUMENT_PATH = $_SERVER['DOCUMENT_ROOT'] . '/mobiapp/';

    $DB_USERNAME = "johel";
    $DB_PASSWORD = "123456";
    $DB_NAME = "blood_groups";
endif;

$UPLOADS_PATH = $DOCUMENT_PATH . "uploads/";
$UPLOADS_URL = $WEB_URL . "uploads/";
$ADMIN_BT_URL = $WEB_URL . "admin_bt/";
$FRONT_BT_URL = $WEB_URL . "front_bt/";

$MAIL_HOST = "";
$MAIL_USERNAME = "";
$MAIL_PASSWORD = "";

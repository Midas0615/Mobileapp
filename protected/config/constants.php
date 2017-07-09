<?php
$PRODUCT_NAME = "Mobi App";
$development = file_exists(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "development");
$HOST_NAME = "localhost";
if ($development):
    error_reporting(E_ERROR);
    $WEB_URL = 'http://' . $_SERVER['HTTP_HOST'] . '/mobiapp/';
    $DOCUMENT_PATH = $_SERVER['DOCUMENT_ROOT'] . '/mobiapp/';

    $DB_USERNAME = "root";
    $DB_PASSWORD = "";
    $DB_NAME = "mobiapp";
else:
    error_reporting(E_ERROR);
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

$MAIL_HOST = "smtp.gmail.com"; 
$MAIL_USERNAME = "svn@volansystech.com"; 
$MAIL_PASSWORD = "techvolanssvn"; 
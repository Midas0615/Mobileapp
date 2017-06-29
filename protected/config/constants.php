<?php
$PRODUCT_NAME = "Postings";
$development = file_exists(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "development");
$HOST_NAME = "localhost";
if ($development):
    $WEB_URL = 'http://' . $_SERVER['HTTP_HOST'] . '/postings/';
    $DOCUMENT_PATH = $_SERVER['DOCUMENT_ROOT'] . '/postings/';

    $DB_USERNAME = "root";
    $DB_PASSWORD = "root";
    $DB_NAME = "posting";
else:
    error_reporting(E_ERROR);
    $WEB_URL = 'http://' . $_SERVER['HTTP_HOST'] . '/postings/';
    $DOCUMENT_PATH = $_SERVER['DOCUMENT_ROOT'] . '/postings/';

    $DB_USERNAME = "sumanmor_posts";
    $DB_PASSWORD = "8EP1PTlZ=@zF";
    $DB_NAME = "sumanmor_postings";
endif;

$UPLOADS_PATH = $DOCUMENT_PATH . "uploads/";
$UPLOADS_URL = $WEB_URL . "uploads/";
$ADMIN_BT_URL = $WEB_URL . "admin_bt/";
$FRONT_BT_URL = $WEB_URL . "front_bt/";

$MAIL_HOST = "smtp.gmail.com"; 
$MAIL_USERNAME = "svn@volansystech.com"; 
$MAIL_PASSWORD = "techvolanssvn"; 
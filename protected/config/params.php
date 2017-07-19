<?php

// this contains the application parameters that can be maintained via GUI
return array(
    'title' => $PRODUCT_NAME,
    'adminEmail' => 'alpeshspce20@gmail.com',
    'orderEmail' => 'noreply@radheclinic.com',
    'contactEmail' => 'info@radheclinic.com',
    'telephone' => '08456800561',
    'fax' => '02081816361',
    'copyrightInfo' => 'Copyright Ltd.',
    'companyAddress' => "Test Address",
    "ADMIN_BT_URL" => $ADMIN_BT_URL,
    "FRONT_BT_URL" => $FRONT_BT_URL,
    "WEB_URL" => $WEB_URL,
    "defaultPageSize" => 20,
    "dateFormatJS" => "dd/mm/yy",
    "timeFormatJS" => 'h:i A',
    "dateFormatPHP" => "d/m/Y",
    "dateTimeFormatPHP" => "d/m/Y h:i A",
    "timeFormatPHP" => "g:i A",
    'allowedImages' => array('jpg,gif,png'),
    "paths" => include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paths.php')
);

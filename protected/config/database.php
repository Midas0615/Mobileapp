<?php
return array(
    'connectionString' => 'mysql:host=' . $HOST_NAME . ';dbname=' . $DB_NAME,
    'emulatePrepare' => true,
    'username' => $DB_USERNAME,
    'password' => $DB_PASSWORD,
    'charset' => 'utf8',
    'enableProfiling' => true,
    'tablePrefix' => "mob_",
    'initSQLs' => array(
        "SET time_zone = '+5:30'"
    ),
);
?>

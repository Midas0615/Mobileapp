<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'constants.php');
return array(
    'id' => 'posting_system',
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => $PRODUCT_NAME,
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.vendors.*',
        'application.helpers.*',
        'ext.yii-mail.YiiMailMessage'
    ),
    'defaultController' => 'home',
    'modules' => array(
        'admin' => array(
            'defaultController' => 'login',
        ),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'mano',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    'aliases' => array(
        'RestfullYii' => realpath(__DIR__ . '/../extensions/starship/RestfullYii'),
    ),
    'components' => array(
        'messages' => array(
            'language' => 'en'
        ),
        'user' => array(
            'class' => 'WebUser',
            'stateKeyPrefix' => '_front',
            'allowAutoLogin' => true,
            'loginUrl' => 'login',
            'allowAutoLogin' => true,
        ),
        'image' => array(
            'class' => 'application.extensions.image.CImageComponent',
            'driver' => 'GD', // GD or ImageMagick            
            'params' => array('directory' => '/opt/local/bin'), // ImageMagick setup path
        ),
        // uncomment the following to use a MySQL database		
        'db' => include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'database.php'),
        'mail' => array('class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => "smtp.gmail.com",
                'username' => "smtp.alpesh@gmail.com",
                'password' => "AlpeshVaghela",
                'port' => '465',
                'encryption' => 'tls'
            ),
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false
        ),
        'errorHandler' => array(
            'errorAction' => 'error/index',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'appendParams' => false,
            'rules' => require dirname(__FILE__) . '/../extensions/starship/RestfullYii/config/routes.php',
        ),
        'widgetFactory' => include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'widgetFactory.php'),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
// using Yii::app()->params['paramName']
    'params' => include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'params.php')
);

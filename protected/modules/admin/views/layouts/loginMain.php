<!DOCTYPE html>
<html>
    <!-- START Head -->
    <head>
        <!-- START META SECTION -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="author" content="pampersdry.info">
        <meta name="description" content="Adminre is a clean and flat admin theme build with Twitter bootstrap 3.1.1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="image/touch/apple-touch-icon-144x144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="image/touch/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="image/touch/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="image/touch/apple-touch-icon-57x57-precomposed.png">
        <link rel="shortcut icon" href="image/touch/apple-touch-icon.png">
        <!--/ END META SECTION -->

        <!-- START STYLESHEETS -->
        <!-- Plugins stylesheet : optional -->

        <!--/ Plugins stylesheet -->

        <!-- Application stylesheet : mandatory -->
        <link rel="stylesheet" href="<?php echo Yii::app()->params->ADMIN_BT_URL;?>stylesheet/style.css">  
        <link rel="stylesheet" href="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>library/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>stylesheet/layout.min.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>stylesheet/uielement.min.css">
        <!--/ Application stylesheet -->
        <!-- END STYLESHEETS -->

        <!-- START JAVASCRIPT SECTION - Load only modernizr script here -->
        <script src="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>library/modernizr/js/modernizr.min.js"></script>
    </head>
    <!--/ END Head -->

    <!-- START Body -->
    <body>
        <!-- START row -->
        <?php echo $content; ?>
        <!--/ END row -->


        <!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
        <!-- Library script : mandatory -->
        <!--
        <script type="text/javascript" src="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>library/jquery/js/jquery.min.js"></script>
        -->
        <script type="text/javascript" src="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>library/jquery/js/jquery-migrate.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>library/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>library/core/js/core.min.js"></script>
        <!--/ Library script -->

        <!-- App and page level script -->
        <script type="text/javascript" src="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>plugins/sparkline/js/jquery.sparkline.min.js"></script><!-- will be use globaly as a summary on sidebar menu -->
        <script type="text/javascript" src="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>javascript/app.min.js"></script>        
        <script type="text/javascript" src="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>plugins/parsley/js/parsley.min.js"></script>
        <!--/ App and page level scrip -->
        <!--/ END JAVASCRIPT SECTION -->
    </body>
    <!--/ END Body -->
</html>
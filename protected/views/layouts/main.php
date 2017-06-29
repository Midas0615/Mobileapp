<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
        <meta name="theme-color" content="#2196F3">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <!-- CSS  -->
        <link href="<?php echo Yii::app()->params->FRONT_BT_URL; ?>min/plugin-min.css" type="text/css" rel="stylesheet">
        <link href="<?php echo Yii::app()->params->FRONT_BT_URL; ?>min/custom-min.css" type="text/css" rel="stylesheet" >
    </head>
    <body id="top" class="scrollspy">
        <?php echo $content; ?>        
    </body>
</html>

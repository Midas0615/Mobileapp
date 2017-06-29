<?php
$controller = Yii::app()->controller->id;
$isLoggedIn = Users::model()->isLoggedIn();
?>
<!-- Pre Loader -->
<div id="loader-wrapper">
    <div id="loader"></div>

    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>

</div>

<!--Navigation-->
<div class="navbar-fixed">
    <nav id="nav_f" class="default_color" role="navigation">
        <div class="container">
            <div class="nav-wrapper">
                <a href="#" id="logo-container" class="brand-logo"><?php echo Yii::app()->params->title; ?></a>
                <ul class="right hide-on-med-and-down">                    
                    <?php if ($isLoggedIn): ?>
<!--                        <li><a href="<?php echo Yii::app()->createUrl("posts"); ?>">Posts</a></li>-->
                        <li><a href="<?php echo Yii::app()->createUrl("account"); ?>">Change Profile</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl("login/logout"); ?>">Logout (<?php echo Yii::app()->user->getFullName(); ?>)</a></li>
                    <?php else : ?>
                        <li><a href="<?php echo Yii::app()->createUrl("home"); ?>#intro">Service</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl("home"); ?>#work">Posts</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl("home"); ?>#team">Team</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl("home"); ?>#contact">Contact</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl("signup"); ?>">Signup</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl("login"); ?>">Login</a></li>
                    <?php endif; ?>
                </ul>
                <ul id="nav-mobile" class="side-nav">
                    <li><a href="<?php echo Yii::app()->createUrl("home"); ?>#intro">Service</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl("home"); ?>#work">Work</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl("home"); ?>#team">Team</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl("home"); ?>#contact">Contact</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl("signup"); ?>">Signup</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl("login"); ?>">Login</a></li>
                </ul>
                <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
            </div>
        </div>
    </nav>
</div>
<header id="header" class="navbar navbar-fixed-top">
    <div class="navbar-header">
        <a class="navbar-brand" href="<?php echo Yii::app()->createUrl("dashboard"); ?>">
            <span class="logo-figure"></span>
            <span class="logo-text-1"></span>
        </a>        
    </div>
    <div class="navbar-toolbar clearfix">
        <ul class="nav navbar-nav navbar-left">
            <li class="hidden-xs hidden-sm">
                <?php
                echo CHtml::Link('<span class="meta"><span class="icon"></span></span>', "javascript:;", array("class" => "sidebar-minimize", "data-toggle" => "minimize", "title" => "Minimize sidebar",
                    "ajax" => array(
                        "url" => Yii::app()->createUrl('common/setmenuview'),
                        "success" => "js:function(){
                                    if($('html').hasClass('sidebar-minimized')){                                       
                                        $('html').removeClass('sidebar-minimized');
                                    }else{                                        
                                        $('html').addClass('sidebar-minimized');
                                    }
                                 }"
                    )
                        )
                );
                ?>
            </li>
            <li class="navbar-toggle">
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="meta">
                        <span class="icon"><i class="ico-sort-by-attributes-alt"></i></span>
                    </span>
                </a>
            </li>
            <li class="navbar-main hidden-lg hidden-md hidden-sm">
                <a href="javascript:void(0);" data-toggle="offcanvas" data-direction="ltr" rel="tooltip" title="Menu sidebar">
                    <span class="meta">
                        <span class="icon"><i class="ico-paragraph-left3"></i></span>
                    </span>
                </a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown profile">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="meta">                        
                        <span class="avatar"><img src="<?php echo Yii::app()->user->getProfilePicture(); ?>" class="img-circle" alt="" /></span>
                        <span class="text hidden-xs hidden-sm pl5" style="font-size: 15px;"><?php echo Yii::app()->user->getFullName(); ?></span>
                        <span class="caret"></span>
                    </span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li><?php echo CHtml::Link('<span class="icon"><i class="ico-user"></i></span> Profile', array("users/profile")); ?></li>
                    <li><?php echo CHtml::Link('<span class="icon"><i class="ico-exit"></i></span> Sign Out', array("login/logout")); ?></li>
                </ul>
            </li>
        </ul>
    </div>
</header>
<aside class="sidebar sidebar-left sidebar-menu">
    <section class="content slimscroll">
        <h5 class="heading">Main Menu</h5>
        <ul data-toggle="menu" class="topmenu">
            <li class="<?php echo!empty(Yii::app()->controller->id == "dashboard") ? "active" : ""; ?>">
                <?php echo CHtml::Link('<span class="figure"><i class="ico-file"></i></span><span class="text">Dashboard</span>', array("/".Yii::app()->controller->module->id."/dashboard")); ?>                
            </li>
            <li class="<?php echo!empty(Yii::app()->controller->id == "product") ? "active" : ""; ?>">
                <?php echo CHtml::Link('<span class="figure"><i class="ico-file"></i></span><span class="text">Products</span>', array("/".Yii::app()->controller->module->id."/product")); ?>
            </li>
            <li class="<?php echo!empty(Yii::app()->controller->id == "order") ? "active" : ""; ?>">
                <?php echo CHtml::Link('<span class="figure"><i class="ico-file"></i></span><span class="text">Orders</span>', array("/".Yii::app()->controller->module->id."/order")); ?>
            </li>
            <li class="<?php echo!empty(Yii::app()->controller->id == "review") ? "active" : ""; ?>">
                <?php echo CHtml::Link('<span class="figure"><i class="ico-file"></i></span><span class="text">Review</span>', array("/".Yii::app()->controller->module->id."/review")); ?>
            </li>
            <li class="<?php echo!empty(Yii::app()->controller->id == "rating") ? "active" : ""; ?>">
                <?php echo CHtml::Link('<span class="figure"><i class="ico-file"></i></span><span class="text">Rating</span>', array("/".Yii::app()->controller->module->id."/rating")); ?>
            </li>
<!--                <li class="<?php echo!empty(Yii::app()->controller->id == "posts") ? "active" : ""; ?>">
                    <?php echo CHtml::Link('<span class="figure"><i class="ico-file"></i></span><span class="text">Posts</span>', array("/".Yii::app()->controller->module->id."/posts")); ?>
                </li>
            <li class="<?php echo!empty(Yii::app()->controller->id == "categories") ? "active" : ""; ?>">
                <?php echo CHtml::Link('<span class="figure"><i class="ico-file"></i></span><span class="text">Categories</span>', array("/".Yii::app()->controller->module->id."/categories")); ?>
            </li>-->
            <li class="<?php echo!empty(Yii::app()->controller->id == "users") ? "active" : ""; ?>">
                <?php echo CHtml::Link('<span class="figure"><i class="ico-file"></i></span><span class="text">Users</span>',array("/".Yii::app()->controller->module->id."/users")); ?>
            </li>
        </ul>
    </section>
</aside>

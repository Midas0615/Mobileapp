<?php
$Order = new Order();
$Product = new Product();
$Users = new Users();
$vendor = new Vendor();
?>
<aside class="sidebar sidebar-left sidebar-menu">
    <section class="content slimscroll">
        <h5 class="heading">Main Menu</h5>
        <ul data-toggle="menu" class="topmenu">
            <li class="<?php echo!empty(Yii::app()->controller->id . "/" . Yii::app()->controller->action->id == "dashboard/index") ? "active" : ""; ?>">
                <?php echo CHtml::Link('<span class="figure"><i class="ico-home"></i></span><span class="text">Home</span>', array("/" . Yii::app()->controller->module->id . "/dashboard")); ?>                
            </li>
            <li class="<?php echo!empty(Yii::app()->controller->id . "/" . Yii::app()->controller->action->id == "order/history") ? "active" : ""; ?>">
                <?php echo CHtml::Link('<span class="figure"><i class="ico-cart"></i></span><span class="text">My Order</span>', array("/" . Yii::app()->controller->module->id . "/order/history")); ?>
            </li>
            <?php if (!common::isDeliveryBoy()) { // 5 delivery boy?>
                <li class="<?php echo!empty(Yii::app()->controller->id . "/" . Yii::app()->controller->action->id == "product/favoriteproduct") ? "active" : ""; ?>">
                    <?php echo CHtml::Link('<span class="figure"><i class="ico-heart"></i></span><span class="text">Favorite Products</span>', array("/" . Yii::app()->controller->module->id . "/product/favoriteproduct")); ?>
                </li>
                <li class="<?php echo!empty(Yii::app()->controller->id . "/" . Yii::app()->controller->action->id == "dashboard/howto") ? "active" : ""; ?>">
                    <?php echo CHtml::Link('<span class="figure"><i class="ico-question"></i></span><span class="text">How to ?</span>', array("/" . Yii::app()->controller->module->id . "/dashboard/howto")); ?>
                </li>
                <li class="<?php echo!empty(Yii::app()->controller->id . "/" . Yii::app()->controller->action->id == "product/index") ? "active" : ""; ?>">
                    <?php echo CHtml::Link('<span class="figure"><i class="ico-gift"></i></span><span class="text">Products</span><span class="number"><span class="label label-primary">'.$Product->countByField().'</span>', array("/" . Yii::app()->controller->module->id . "/product")); ?>
                </li>
                <li class="<?php echo!empty(Yii::app()->controller->id . "/" . Yii::app()->controller->action->id == "order/index") ? "active" : ""; ?>">
                    <?php echo CHtml::Link('<span class="figure"><i class="ico-list"></i></span><span class="text">All Orders </span><span class="number"><span class="label label-primary">'.$Order->countByField().'</span>', array("/" . Yii::app()->controller->module->id . "/order")); ?>
                </li>
                <li class="<?php echo!empty(Yii::app()->controller->id == "review") ? "active" : ""; ?>">
                    <?php echo CHtml::Link('<span class="figure"><i class="ico-vcard"></i></span><span class="text">Product Review</span></span>', array("/" . Yii::app()->controller->module->id . "/review")); ?>
                </li>
                <li class="<?php echo!empty(Yii::app()->controller->id == "rating") ? "active" : ""; ?>">
                    <?php echo CHtml::Link('<span class="figure"><i class="ico-star-half-full"></i></span><span class="text">Product Rating</span>', array("/" . Yii::app()->controller->module->id . "/rating")); ?>
                </li>
                <li class="<?php echo!empty(Yii::app()->controller->id == "vendor") ? "active" : ""; ?>">
                    <?php echo CHtml::Link('<span class="figure"><i class="ico-truck"></i></span><span class="text">Vendors</span><span class="number"><span class="label label-danger">'.$vendor->countByField().'</span>', array("/" . Yii::app()->controller->module->id . "/vendor")); ?>
                </li>
                <li class="<?php echo!empty(Yii::app()->controller->id . "/" . Yii::app()->controller->action->id == "users/deliveryboy") ? "active" : ""; ?>">
                    <?php echo CHtml::Link('<span class="figure"><i class="ico-bus"></i></span><span class="text">Delivery Boys</span>', array("/" . Yii::app()->controller->module->id . "/users/deliveryboy")); ?>
                </li>
                <li class="<?php echo!empty(Yii::app()->controller->id . "/" . Yii::app()->controller->action->id == "users/index") ? "active" : ""; ?>">
                    <?php echo CHtml::Link('<span class="figure"><i class="ico-users"></i></span><span class="text">Users</span><span class="number"><span class="label label-success">'.$Users->countByField().'</span>', array("/" . Yii::app()->controller->module->id . "/users")); ?>
                </li>
            <?php } ?>
        </ul>
    </section>
</aside>

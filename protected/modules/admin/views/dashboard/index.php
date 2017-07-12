<div class="container-fluid">
    <?php
    $this->renderPartial("/layouts/_message");
    $Order = new Order();
    $Product = new Product();
    $Users = new Users();
    if (!common::isDeliveryBoy()) {
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><i class="ico-file mr5"></i>Products</h5>
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">Total <span class="semibold pull-right"><?php echo $Product->countByField(); ?></span></li>
                                <li class="list-group-item">Active<span class="semibold pull-right"><?php echo $Product->countByField("status", Product::Active); ?></span></li>
                                <li class="list-group-item">De Active <span class="semibold pull-right"><?php echo $Product->countByField("status", Product::DE_ACTIVE); ?></span></li>
                                <li class="list-group-item">Out of Stock <span class="semibold pull-right"><?php echo $Product->countByField("status", Product::OUT_OF_STOCK); ?></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><i class="ico-user7 mr5"></i>Orders</h5>
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">Total <span class="semibold pull-right"><?php echo $Order->countByField(); ?></span></li>
                                <li class="list-group-item">New <span class="semibold pull-right"><?php echo $Order->countByField("status", Order::NEW_ORDER); ?></span></li>
                                <li class="list-group-item">Received<span class="semibold pull-right"><?php echo $Order->countByField("status", Order::RECEIVED); ?></span></li>
                                <!--<li class="list-group-item">Active <span class="semibold pull-right"><?php echo $Order->countByField("status", Order::OUT_OF_DELIVERY); ?></span></li>-->
                                <li class="list-group-item">Completed <span class="semibold pull-right"><?php echo $Order->countByField("status", Order::COMPLETED); ?></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><i class="ico-users mr5"></i>Users</h5>
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">Total <span class="semibold pull-right"><?php echo $Users->countByField(); ?></span></li>
                                <!--<li class="list-group-item">Verified <span class="semibold pull-right"><?php echo $Users->countByField("is_verified", 1); ?></span></li>-->
                                <li class="list-group-item">Not Verified <span class="semibold pull-right"><?php echo $Users->countByField("is_verified", 0); ?></span></li>
                                <li class="list-group-item">Active <span class="semibold pull-right"><?php echo $Users->countByField("status", Users::ACTIVE); ?></span></li>
                                <li class="list-group-item">Inactive <span class="semibold pull-right"><?php echo $Users->countByField("status", Users::IN_ACTIVE); ?></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Calender</h3>
                </div>
                <div class="panel-body">
                    <?php
                    $this->widget('application.extensions.fullcalendar.FullcalendarGraphWidget', array(
                        'data' => $data,
                        'options' => array(
                            'editable' => true,
                        ),
                        'htmlOptions' => array(
                            'style' => 'width:800px;margin: 0 auto;'
                        ),
                            )
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
    </div>
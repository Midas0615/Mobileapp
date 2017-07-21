<div class="container-fluid">
    <div class="page-header page-header-block">
        <div class="page-header-section">
            <h4 class="title semibold">Dashboard</h4>
        </div>
    </div>
    <?php
    $this->renderPartial("/layouts/_message");
    $Order = new Order();
    $Product = new Product();
    $Users = new Users();
    $vendor = new Vendor();
    if (!common::isDeliveryBoy()) {
        ?>
        <div class="row">
            <div class="col-sm-3">
                <!-- START Statistic Widget -->
                <div class="table-layout animation delay animating fadeInDown">
                    <div class="col-xs-4 panel bgcolor-info">
                        <div class="ico-users3 fsize24 text-center"></div>
                    </div>
                    <div class="col-xs-8 panel">
                        <div class="panel-body text-center">
                            <h4 class="semibold nm"><?php echo $Users->countByField(); ?></h4>
                            <p class="semibold text-muted mb0 mt5">REGISTERED USERS</p>
                        </div>
                    </div>
                </div>
                <!--/ END Statistic Widget -->
            </div>
            <div class="col-sm-3">
                <!-- START Statistic Widget -->
                <div class="table-layout animation delay animating fadeInUp">
                    <div class="col-xs-4 panel bgcolor-teal">
                        <div class="ico-gift fsize24 text-center"></div>
                    </div>
                    <div class="col-xs-8 panel">
                        <div class="panel-body text-center">
                            <h4 class="semibold nm"><?php echo $Product->countByField(); ?></h4>
                            <p class="semibold text-muted mb0 mt5">AVAILABLE PRODUCT</p>
                        </div>
                    </div>
                </div>
                <!--/ END Statistic Widget -->
            </div>
            <div class="col-sm-3">
                <!-- START Statistic Widget -->
                <div class="table-layout animation delay animating fadeInDown">
                    <div class="col-xs-4 panel bgcolor-primary">
                        <div class="ico-list fsize24 text-center"></div>
                    </div>
                    <div class="col-xs-8 panel">
                        <div class="panel-body text-center">
                            <h4 class="semibold nm"><?php echo $Order->countByField(); ?></h4>
                            <p class="semibold text-muted mb0 mt5">ORDERS</p>
                        </div>
                    </div>
                </div>
                <!--/ END Statistic Widget -->
            </div>
            <div class="col-sm-3">
                <!-- START Statistic Widget -->
                <div class="table-layout animation delay animating fadeInDown">
                    <div class="col-xs-4 panel bgcolor-info">
                        <div class="ico-truck fsize24 text-center"></div>
                    </div>
                    <div class="col-xs-8 panel">
                        <div class="panel-body text-center">
                            <h4 class="semibold nm"><?php echo $vendor->countByField(); ?></h4>
                            <p class="semibold text-muted mb0 mt5">REGISTERED VENDOR</p>
                        </div>
                    </div>
                </div>
                <!--/ END Statistic Widget -->
            </div>
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
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="panel-icon mr5"><i class="ico-calendar3"></i></span> Calendar</h3>
                    <div class="panel-toolbar text-right">
                        <!-- option -->
                        <div class="option">
                            <button class="btn up" data-toggle="panelcollapse"><i class="arrow"></i></button>
                            <button class="btn" data-toggle="panelremove"><i class="remove"></i></button>
                        </div>
                        <!--/ option -->
                    </div>
                </div>
                <div class="panel-body panel-collapse pull out">
                    <?php
                    //
//                    $this->widget('application.extensions.fullcalendar.FullcalendarGraphWidget', array(
//                        'data' => $data,
//                        'options' => array(
//                            'editable' => true,
//                        ),
//                        //'events'=> $data,
//                        'htmlOptions' => array(
//                            'style' => 'width:100%;margin: 0 auto;'
//                        ),
//                            )
//                    );
                    ?>
                    <div class="box-content">
                        <div id="DRCcalendar"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
//    jQuery.noConflict(true);
//    var u1 = '<?php echo Yii::app()->params->WEB_URL . "admin/dashboard/events"; ?>';
//    var source = new Array();
//    $.get(u1, function (data) {
//        source[0] = data;
//        $("#DRCcalendar").fullCalendar({
//            header: {
//                left: "prev,next",
//                center: "title",
//                right: "month,agendaWeek,agendaDay",
//            },
//            eventSources: [
//                source[0],
//                source[1]
//            ],
//            columnFormat: {
//                month: 'dddd', // Monday, Wednesday, etc
//                week: 'dddd, MMM dS', // Monday 9/7
//                day: 'dddd, MMM dS'  // Monday 9/7
//            }
//        });
//    });
//    source[1] = '';
//    var newSource = new Array();
//    newSource[0] = source[0];
//    newSource[1] = source[1];
//    $(document).ready(function () {
//        debugger;
//
//    });
</script>
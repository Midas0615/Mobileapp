<!-- START Template Container -->
<div class="container-fluid">
    <!-- START row -->
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- START panel -->
            <div class="panel panel-default">
                <!-- panel heading/header -->
                <div class="panel-heading">
                    <h3 class="panel-title">Update Email</h3>
                </div>
                <!--/ panel heading/header -->
                <!-- panel body -->
                <div class="panel-body">
                    <?php $this->renderPartial("_form_email",array("model"=>$model)); ?>
                 </div>
                <!-- panel body -->
            </div>
            <!--/ END form panel -->
        </div>
    </div>
    <!--/ END row -->
</div>
<!--/ END Template Container -->
<!-- START Template Container -->
<div class="container">
    <div class="row">
        <div class="col-md-12 center">
            <h4 class="heading-dark mt-xl"><strong>Add Post</strong></h4>
        </div>
    </div>
    <!-- START row -->
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <div class="col l12">
            <!-- START panel -->
            <div class="panel panel-default">
                <!-- panel body -->
                <div class="panel-body">
                    <?php $this->renderPartial("_form", array('model' => $model)); ?>
                </div>
                <!-- panel body -->
            </div>
            <!--/ END form panel -->
        </div>
    </div>
    <!--/ END row -->
</div>
<!--/ END Template Container -->

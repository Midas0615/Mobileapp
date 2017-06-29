<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div style="margin-top:10%;" class="panel panel-minimal">
            <!-- Upper Text -->
            <div class="panel-body text-center">
                <i class="ico-shield4 longshadow fsize112 text-default"></i>
            </div>
            <div class="panel-body text-center">
                <h1 class="semibold longshadow text-center text-default fsize32 mb10 mt0">HOLD UP!!</h1>
                <h4 class="semibold text-primary text-center nm">You dont have permission to access this...</h4>
            </div>
            <!--/ Upper Text -->

            <!-- Button -->
            <div class="panel-body text-center">
                <?php echo CHtml::Link("Back To Dashboard",array("/".Yii::app()->controller->module->id."/dashboard"),array("class"=>"btn btn-success mb5")); ?>
                <!--<span class="semibold text-default hidden-xs">&nbsp;&nbsp;OR&nbsp;&nbsp;</span>
                <a href="javascript:void(0);" class="btn btn-success mb5">Report This Problem</a>-->
            </div>
            <!--/ Button -->
        </div>
    </div>
</div>
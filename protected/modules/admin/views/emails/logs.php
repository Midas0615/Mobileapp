<!-- START Template Container -->
<div class="container-fluid">
    <!-- START row -->
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
            <div class="panel-toolbar-wrapper pl0 pt5 pb5">
                    <div class="panel-toolbar pl10">
                        <div class="pull-left">
                            <span class="semibold">&nbsp;&nbsp;Email Logs</span>  
                        </div>
                    </div>                    
                </div>
                <!-- panel body with collapse capabale -->
                <div class="table-responsive panel-collapse pull out">                  
                <?php
                   $updateRight = common::checkActionAccess("emails/logs");
                   $deleteRight = common::checkActionAccess("users/delete");
                   $columnClass = (!$updateRight && !$deleteRight)?"hide":"";
                   $this->widget("zii.widgets.grid.CGridView", array(
                    "id"=>"emails-grid",
                    "dataProvider"=>$model->search(),           
                    "columns"=>array(
                        array(
                            "class"=>"CCheckBoxColumn",
                            "selectableRows" => 2,
                            "htmlOptions"=>array("width"=>"3%"),
                        ),
                        "email_from",
                        "email_to",
                        array(
                            "header"=>"Email Sent ?",
                            "name"=>"is_email_sent",
                            "value"=>'!empty($data->is_email_sent)?"'.common::translateText("YES_LABEL").'":"'.common::translateText("NO_LABEL").'"',
                            "htmlOptions"=>array("width"=>"15%"),
                        )
                    ),
                ));
                Yii::app()->clientScript->registerScript('actions', "
                    $('.deleteRecord').live('click',function() {
                        if(!confirm('".common::translateText("DELETE_CONFIRM")."')) return false;                        
                        var url = $(this).attr('href');
                        $.post(url,function(res){
                            $.fn.yiiGridView.update('emails-grid');
                            $('#flash-message').html(res).animate({opacity: 1.0}, 3000).fadeOut('slow');
                        });
                        return false;
                    });
                ");
                ?>                    
                </div>
                <!--/ panel body with collapse capabale -->
            </div> 
        </div>      
    </div>
    <!--/ END row -->
</div>
<!--/ END Template Container -->
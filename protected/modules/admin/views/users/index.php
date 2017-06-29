<!-- START Template Container -->
<div class="container-fluid">
    <?php $this->renderPartial("_search", array("model" => $model)); ?>
    <!-- START row -->
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-toolbar-wrapper pl0 pt5 pb5">
                    <div class="panel-toolbar pl10">
                        <div class="pull-left">
                            <span class="semibold">&nbsp;&nbsp;Users</span>  
                        </div>
                    </div>
                    <div class="panel-toolbar text-right">
                        <?php
                        echo CHtml::Link('Add User <i class="ico-plus"></i>', array("users/add"), array(
                            "title" => "Add User",
                            "data-placement" => "bottom",
                            "rel" => "tooltip",
                            "class" => "btn btn-sm btn-default",
                            "data-original-title" => "Add User"
                        ));
                        ?>
                    </div>
                </div>
                <div class="table-responsive panel-collapse pull out">                  
                    <?php
                    $updateRight = true;
                    $deleteRight = true;
                    $columnClass = (!$updateRight && !$deleteRight) ? "hide" : "";
                    $this->widget("zii.widgets.grid.CGridView", array(
                        "id" => "users-grid",
                        "dataProvider" => $model->search(),
                        "columns" => array(
                            array(
                                "header" => "Name",
                                "name" => "first_name",
                                "value" => '$data->first_name." ".$data->last_name'
                            ),
                            "email_address",
                            array(
                                "name" => "user_group",
                                "value" => '!empty($data->usersGroupRel->group_name)?$data->usersGroupRel->group_name:"--"'
                            ),
                            "created_dt",
                            "phone_number",
                            "last_login",
                            array(
                                'name' => 'status',
                                'value' => '!empty($data->statusArr[$data->status])?$data->statusArr[$data->status]:"--"',
                                "htmlOptions" => array("width" => "10%")
                            ),
                            array(
                                "class" => "CButtonColumn",
                                "header" => "Action",
                                "htmlOptions" => array("width" => "10%", "class" => "text-center $columnClass"),
                                "headerHtmlOptions" => array("width" => "10%", "class" => "text-center $columnClass"),
                                "template" => '<div class="toolbar">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-default" type="button">Action</button>
                                                <button data-toggle="dropdown" class="btn btn-sm btn-default dropdown-toggle" type="button">
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li>{updateRecord}</li>
                                                    <li>{deleteRecord}</li>
                                                </ul>
                                            </div>
                                        </div>',
                                "buttons" => array(
                                    "updateRecord" => array(
                                        "label" => '<i class="icon ico-pencil"></i> ' . common::translateText("UPDATE_BTN_TEXT"),
                                        "imageUrl" => false,
                                        "url" => 'Yii::app()->createUrl("/".Yii::app()->controller->module->id."/users/update", array("id"=>$data->id))',
                                        "options" => array("class" => "addUpdateRecord mr5", "title" => common::translateText("UPDATE_BTN_TEXT")),
                                        "visible" => ($updateRight) ? 'true' : 'false',
                                    ),
                                    "deleteRecord" => array(
                                        "label" => '<i class="icon ico-trash"></i> ' . common::translateText("DELETE_BTN_TEXT"),
                                        "imageUrl" => false,
                                        "url" => 'Yii::app()->createUrl("/".Yii::app()->controller->module->id."/users/delete", array("id"=>$data->id))',
                                        "options" => array("class" => "deleteRecord text-danger mr5", "title" => common::translateText("DELETE_BTN_TEXT")),
                                        "visible" => ($deleteRight) ? 'true' : 'false',
                                    ),
                                ),
                            ),
                        ),
                    ));
                    Yii::app()->clientScript->registerScript('actions', "
                    $('.deleteRecord').live('click',function() {
                        if(!confirm('" . common::translateText("DELETE_CONFIRM") . "')) return false;                        
                        var url = $(this).attr('href');
                        $.post(url,function(res){
                            $.fn.yiiGridView.update('users-grid');
                            $('#flash-message').html(res).animate({opacity: 1.0}, 3000).fadeOut('slow');
                        });
                        return false;
                    });
                ");
                    ?>                    
                </div>
            </div> 
        </div>      
    </div>
</div>
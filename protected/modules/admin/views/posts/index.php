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
                            <span class="semibold">&nbsp;&nbsp;Posts</span>  
                        </div>
                    </div>
                    <div class="panel-toolbar text-right">
                        <?php
                        echo CHtml::Link("Add Post" . ' <i class="ico-plus"></i>', array($this->id . DS . "add"), array(
                            "title" => "Add Post",
                            "data-placement" => "bottom",
                            "rel" => "tooltip",
                            "class" => "btn btn-sm btn-default",
                            "data-original-title" => "Add Post"
                        ));
                        echo CHtml::Link('Publish', array("/".Yii::app()->controller->module->id."/posts/status"), array("class" => "ml5 btn btn-sm btn-success changeStatus"));
                        ?>
                    </div>
                </div>
                <!-- panel body with collapse capabale -->
                <div class="table-responsive panel-collapse pull out">                  
                    <?php
                    $updateRight = true;
                    $deleteRight = true;
                    $columnClass = (!$updateRight && !$deleteRight) ? "hide" : "";
                    $this->widget("zii.widgets.grid.CGridView", array(
                        "id" => "posts-grid",
                        "dataProvider" => $model->search(),
                        "columns" => array(
                            array(
                                'class' => 'CCheckBoxColumn',
                                'selectableRows' => 2,
                                'value' => '$data["id"]',
                                "checkBoxHtmlOptions" => array("name" => "idList[]"),
                            ),
                            array(
                                'name' => 'status',
                                'value' => '!empty($data->statusArr[$data->status])?$data->statusArr[$data->status]:"--"',
                                "htmlOptions" => array("width" => "10%")
                            ),
                            "id",
                            array(
                                "name" => "image",
                                "type" => "raw",
                                "value" => '"<div class=\"media-object\">".CHtml::Image($data->getImage($data->image,$data->id),"--",array("class"=>"img-circle","height"=>"30","width"=>"100"))."</div>"',
                                "htmlOptions" => array("width" => "1%", "class" => "text-center")
                            ),
                            "title",
                            array(
                                'name' => 'author_id',
                                'value' => '!empty($data->authorRel->full_name)?$data->authorRel->full_name:"--"'
                            ),
                            array(
                                'name' => 'created_dt',
                                'value' => '$data->created_dt'
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
                                        "url" => 'Yii::app()->createUrl("/".Yii::app()->controller->module->id."/posts/update", array("id"=>$data->id))',
                                        "options" => array("class" => "addUpdateRecord mr5", "title" => "Update Post"),
                                        "visible" => ($updateRight) ? 'true' : 'false',
                                    ),
                                    "deleteRecord" => array(
                                        "label" => '<i class="icon ico-trash"></i> ' . common::translateText("DELETE_BTN_TEXT"),
                                        "imageUrl" => false,
                                        "url" => 'Yii::app()->createUrl("/".Yii::app()->controller->module->id."/posts/delete", array("id"=>$data->id))',
                                        "options" => array("class" => "deleteRecord text-danger mr5", "title" => "Delete Post"),
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
                        var idList = '';
                        $('.changeStatus').live('click',function() 
                        {
                            if($(this).hasClass('changeStatus'))
                            {
                                var idList    = $('input[type=checkbox]:checked').serialize();
                                if(!idList){
                                    alert('" . common::translateText("INVALID_SELECTION") . "'); return false;  
                                }
                            }
                            if(!confirm('Are you sure to perform this action ?')) return false;                        
                            var url = $(this).attr('href');
                            $.post(url,idList,function(res){
                                $.fn.yiiGridView.update('posts-grid');
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
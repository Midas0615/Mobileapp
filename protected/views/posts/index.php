<!-- START Template Container -->
<div class="container">
    <div class="row">
        <div class="col-md-12 center">
            <h4 class="heading-dark mt-xl"><strong>Posts</strong></h4>
        </div>
    </div>
    <?php // $this->renderPartial("_search", array("model" => $model)); ?>
    <!-- START row -->
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <div class="col l12">
            <div class="panel panel-primary">
                <div class="panel-toolbar-wrapper pl0 pt5 pb5">
                    <div class="panel-toolbar text-right">
                        <?php
                            echo CHtml::Link("Add Post" . ' <i class="ico-plus"></i>', array($this->id . DS . "add"), array(
                                "title" => "Add Post",
                                "data-placement" => "bottom",
                                "rel" => "tooltip",
                                "class" => "btn btn-sm btn-default",
                                "data-original-title" => "Add Post"
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
                        "id" => "posts-grid",
                        "dataProvider" => $model->search(),
                        "columns" => array(
                            array(
                                'name' => 'status',
                                'value' => '!empty($data->statusArr[$data->status])?$data->statusArr[$data->status]:"--"',
                                "htmlOptions" => array("width" => "10%")
                            ),
                            "id",
                            array(
                                "name" => "image",
                                "type" => "raw",
                                "value" => '"<div class=\"media-object\">".CHtml::Image($data->getImage($data->image,$data->id),"--",array("class"=>"img-circle","height"=>"100","width"=>"100"))."</div>"',
                                "htmlOptions" => array("width" => "1%", "class" => "text-center")
                            ),
                            "title",
                            array(
                                'name' => 'created_dt',
                                'value' => '$data->created_dt'
                            ),
                            array(
                                'name' => 'updated_dt',
                                'value' => '$data->updated_dt'
                            ),
                            array(
                                "class" => "CButtonColumn",
                                "header" => "Action",
                                "htmlOptions" => array("width" => "10%", "class" => "text-center $columnClass"),
                                "headerHtmlOptions" => array("width" => "10%", "class" => "text-center $columnClass"),
                                "template" => '{updateRecord}{deleteRecord}',
                                "buttons" => array(
                                    "updateRecord" => array(
                                        "label" => '<i class="icon ico-pencil"></i> ' . common::translateText("UPDATE_BTN_TEXT"),
                                        "imageUrl" => false,
                                        "url" => 'Yii::app()->createUrl("posts/update", array("id"=>$data->id))',
                                        "options" => array("class" => "addUpdateRecord mr5", "title" => "Update Post"),
                                        "visible" => ($updateRight) ? 'true' : 'false',
                                    ),
                                    "deleteRecord" => array(
                                        "label" => '<i class="icon ico-trash"></i> ' . common::translateText("DELETE_BTN_TEXT"),
                                        "imageUrl" => false,
                                        "url" => 'Yii::app()->createUrl("posts/delete", array("id"=>$data->id))',
                                        "options" => array("class" => "deleteRecord text-danger mr5", "title" => "Delete Post")),
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
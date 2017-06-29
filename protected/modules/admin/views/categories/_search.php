<div class="page-header page-header-block">
    <?php
    Yii::app()->clientScript->registerScript('search', "
        $('#search_form').submit(function(){
            $.fn.yiiGridView.update('".$this->id."-grid', {
                data: $('#search_form').serialize()
            });
            return false;
        });
    ");
    $form = $this->beginWidget('CActiveForm', array("method" => "GET", "id" => "search_form", "htmlOptions" => array("onSubmit" => "return false")));
    ?>
    <div class="page-header-section">
        <div class="toolbar clearfix">
            <div class="col-xs-11">
                <?php echo $form->textField($model, "id", array("class" => "form-control", "placeholder" => "E.g Sports")) ?>
            </div>
            <div class="col-xs-1">
                <button class="btn btn-primary pull-right"><i class="ico-loop4 mr5"></i>Search</button>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>

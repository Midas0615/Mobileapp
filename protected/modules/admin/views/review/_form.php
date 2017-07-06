<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ), 'htmlOptions' => array('enctype' => 'multipart/form-data')));
?>
<div class="row nm">
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "product_id", array("class" => "control-label")); ?>
            <?php echo $form->dropDownList($model, "product_id", Product::model()->getAllProductList(), array("class" => "form-control")); ?>
            <?php echo $form->error($model, "product_id", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
 
    <div class="col-md-8">
        <div class="form-group">
            <?php echo $form->labelEx($model, "comments", array("class" => "control-label")); ?>
            <?php echo $form->textArea($model, "comments", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("comments"))); ?>                
            <?php echo $form->error($model, "comments", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="js:history.go(-1);"><?php echo common::translateText("CANCEL_BTN_TEXT"); ?></button>
    <button type="submit" class="btn btn-primary"><?php echo common::translateText("SUBMIT_BTN_TEXT"); ?></button>
</div>
<?php $this->endWidget(); ?>
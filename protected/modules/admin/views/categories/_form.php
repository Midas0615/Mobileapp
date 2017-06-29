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
    <div class="col-md-12">
        <div class="form-group">
            <?php echo $form->labelEx($model, "title", array("class" => "control-label")); ?>
            <?php echo $form->textField($model, "title", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("title"))); ?>                
            <?php echo $form->error($model, "title", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
<!--    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model, "parent_id", array("class" => "control-label")); ?>
            <?php echo $form->dropDownList($model, "parent_id", Categories::model()->getParentCategoriesList(), array("class" => "form-control", "prompt" => $model->getAttributeLabel("parent_id"))); ?>
            <?php echo $form->error($model, "parent_id", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>-->
</div>
<div class="row nm">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo $form->labelEx($model, "description", array("class" => "control-label")); ?>
            <?php echo $form->textArea($model, "description", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("description"))); ?>
            <?php echo $form->error($model, "description", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="js:history.go(-1);"><?php echo common::translateText("CANCEL_BTN_TEXT"); ?></button>
    <button type="submit" class="btn btn-primary"><?php echo common::translateText("SUBMIT_BTN_TEXT"); ?></button>
</div>
<?php $this->endWidget(); ?>
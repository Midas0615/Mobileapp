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
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "user_id", array("class" => "control-label")); ?>
            <?php echo $form->dropDownList($model, "user_id", Users::model()->getAllUserList(), array("class" => "form-control")); ?>
            <?php echo $form->error($model, "user_id", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group" style="display: grid;">
            <?php echo $form->labelEx($model, "star", array("class" => "control-label")); ?>
            <?php $form->widget('CStarRating', array('name' => 'star','starCount' => 5, 'minRating' => 1, 'maxRating' => 5,'value'=>$model->star)); ?>
            <?php echo $form->error($model, "star", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="js:history.go(-1);"><?php echo common::translateText("CANCEL_BTN_TEXT"); ?></button>
    <button type="submit" class="btn btn-primary"><?php echo common::translateText("SUBMIT_BTN_TEXT"); ?></button>
</div>
<?php $this->endWidget(); ?>
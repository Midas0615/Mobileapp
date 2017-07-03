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
            <?php echo $form->labelEx($model, "user_id", array("class" => "control-label")); ?>
            <?php echo $form->dropDownList($model, "user_id", Users::model()->getAllUserList(), array("class" => "form-control")); ?>
            <?php echo $form->error($model, "user_id", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "product_id", array("class" => "control-label")); ?>
            <?php echo $form->dropDownList($model, "product_id", Product::model()->getAllProductList(), array("class" => "form-control")); ?>
            <?php echo $form->error($model, "product_id", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "qty", array("class" => "control-label")); ?>
            <?php echo $form->textField($model, "qty", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("qty"))); ?>                
            <?php echo $form->error($model, "qty", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class ="row nm">
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "address", array("class" => "control-label")); ?>
            <?php echo $form->textField($model, "address", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("address"))); ?>                
            <?php echo $form->error($model, "address", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "order_amount", array("class" => "control-label")); ?>
            <?php echo $form->textField($model, "order_amount", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("order_amount"))); ?>                
            <?php echo $form->error($model, "order_amount", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "order_date", array("class" => "control-label")); ?>
            <?php echo $form->textField($model, "order_date", array("class" => "form-control datepicker",'id'=>'datepicker', "placeholder" => $model->getAttributeLabel("order_date"))); ?>                
            <?php echo $form->error($model, "order_date", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class="row nm">
    <div class="col-md-8">
        <div class="form-group">
            <?php echo $form->labelEx($model, "summary", array("class" => "control-label")); ?>
            <?php echo $form->textarea($model, "summary", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("summary"))); ?>                
            <?php echo $form->error($model, "summary", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "status", array("class" => "control-label")); ?>
            <?php echo $form->dropDownList($model, "status", $model->statusArr, array("class" => "form-control")); ?>
            <?php echo $form->error($model, "status", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="js:history.go(-1);"><?php echo common::translateText("CANCEL_BTN_TEXT"); ?></button>
    <button type="submit" class="btn btn-primary"><?php echo common::translateText("SUBMIT_BTN_TEXT"); ?></button>
</div>
<?php $this->endWidget(); ?>
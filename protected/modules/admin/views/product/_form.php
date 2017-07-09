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
            <?php echo $form->labelEx($model, "title", array("class" => "control-label")); ?>
            <?php echo $form->textField($model, "title", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("title"))); ?>                
            <?php echo $form->error($model, "title", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "price", array("class" => "control-label")); ?>
            <?php echo $form->textField($model, "price", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("price"))); ?>                
            <?php echo $form->error($model, "price", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "description", array("class" => "control-label")); ?>
            <?php echo $form->textField($model, "description", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("description"))); ?>                
            <?php echo $form->error($model, "description", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class ="row nm">
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "vendor", array("class" => "control-label")); ?>
            <?php echo $form->dropDownList($model, "vendor", Vendor::model()->getAllVendorList(), array("class" => "form-control")); ?>              
            <?php echo $form->error($model, "vendor", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "location", array("class" => "control-label")); ?>
            <?php echo $form->textField($model, "location", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("location"))); ?>                
            <?php echo $form->error($model, "location", array("class" => "parsley-custom-error-message")); ?>
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
<div class="row nm">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo $form->labelEx($model, "long_description", array("class" => "control-label")); ?>
            <?php echo $form->textArea($model, "long_description", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("long_description"))); ?>
            <?php echo $form->error($model, "long_description", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <?php echo $form->labelEx($model, "photo", array("class" => "control-label")); ?>
            <?php echo $form->fileField($model, "photo", array("class" => "form-control2")); ?>                 
            <?php echo $form->error($model, "photo", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-2 pull-right">
        <div class="btn-group pr5">
            <?php $model->photo = !empty($model->photo) ? $model->photo : common::translateText("NOT_AVAILABLE_TEXT"); ?>
            <img alt="No Image" src="<?php echo $model->getImage($model->photo, $model->id); ?>" class="img-circle img-bordered"  width="<?php echo Users::THUMB_WIDTH; ?>" height="<?php echo Users::THUMB_HEIGHT; ?>" />
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="js:history.go(-1);"><?php echo common::translateText("CANCEL_BTN_TEXT"); ?></button>
    <button type="submit" class="btn btn-primary"><?php echo common::translateText("SUBMIT_BTN_TEXT"); ?></button>
</div>
<?php $this->endWidget(); ?>
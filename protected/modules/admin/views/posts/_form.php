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
            <?php echo $form->labelEx($model, "category_id", array("class" => "control-label")); ?>
            <?php echo $form->dropDownList($model, "category_id", Categories::model()->getParentCategoriesList(), array("class" => "form-control", "prompt" => $model->getAttributeLabel("category_id"))); ?>
            <?php echo $form->error($model, "category_id", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <?php echo $form->labelEx($model, "image", array("class" => "control-label")); ?>
            <?php echo $form->fileField($model, "image", array("class" => "form-control2")); ?>                 
            <?php echo $form->error($model, "image", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-2 pull-right">
        <div class="btn-group pr5">
            <?php $model->image = !empty($model->image) ? $model->image : common::translateText("NOT_AVAILABLE_TEXT"); ?>
            <img alt="No Image" src="<?php echo $model->getImage($model->image, $model->id); ?>" class="img-circle img-bordered"  width="<?php echo Users::THUMB_WIDTH; ?>" height="<?php echo Users::THUMB_HEIGHT; ?>" />
        </div>
    </div>
</div>
<?php $hide = ($this->isAuthor) ? "hide" : ""; ?>
<div class ="row nm <?php echo $hide; ?>">
    <div class = "col-md-6">
        <div class = "form-group">
            <?php echo $form->labelEx($model, "author_id", array("class" => "control-label"));
            ?>
            <?php echo $form->dropDownList($model, "author_id", Users::model()->getAuthorList(), array("class" => "form-control", "prompt" => $model->getAttributeLabel("author_id"))); ?>
            <?php echo $form->error($model, "author_id", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model, "status", array("class" => "control-label")); ?>
            <?php echo $form->dropDownList($model, "status", $model->statusArr, array("class" => "form-control")); ?>
            <?php echo $form->error($model, "status", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class="row nm">
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model, "start_date", array("class" => "control-label")); ?>
            <?php common::getDatePicker($model, "start_date", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("start_date"))); ?>
            <?php echo $form->error($model, "start_date", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model, "end_date", array("class" => "control-label")); ?>
            <?php common::getDatePicker($model, "end_date", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("end_date"))); ?>
            <?php echo $form->error($model, "end_date", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class="row nm">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo $form->labelEx($model, "link", array("class" => "control-label")); ?>
            <?php echo $form->textField($model, "link", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("link"))); ?>
            <?php echo $form->error($model, "link", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
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
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'form-email',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),'htmlOptions'=>array('enctype'=>'multipart/form-data')));
?>
<div class="row nm">
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model,"email_title",array("class"=>"control-label"));?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model,"email_title",array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("email_title")));?>
                <i class="ico-envelop form-control-icon"></i>
            </div>
            <?php echo $form->error($model,"email_title",array("class"=>"parsley-custom-error-message"));?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model,"email_keyword",array("class"=>"control-label"));?>
            <div class="has-icon pull-left">
                <?php 
                    $disabled = (!$model->isNewRecord)?true:false;
                    echo $form->textField($model,"email_keyword",array("class"=>"form-control", "disabled"=>$disabled, "placeholder"=>$model->getAttributeLabel("email_keyword")));
                ?>
                <i class="ico-envelop form-control-icon"></i>
            </div>
            <?php echo $form->error($model,"email_keyword",array("class"=>"parsley-custom-error-message"));?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model,"email_subject",array("class"=>"control-label"));?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model,"email_subject",array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("email_subject")));?>
                <i class="ico-envelop form-control-icon"></i>
            </div>
            <?php echo $form->error($model,"email_subject",array("class"=>"parsley-custom-error-message"));?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model,"email_from",array("class"=>"control-label"));?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model,"email_from",array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("email_from")));?>
                <i class="ico-envelop form-control-icon"></i>
            </div>
            <?php echo $form->error($model,"email_from",array("class"=>"parsley-custom-error-message"));?>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <?php echo $form->labelEx($model,"email_content",array("class"=>"control-label"));?>
            <div class="has-icon pull-left">                
                <?php echo $form->textArea($model,"email_content",array("class"=>"summernote"));?>
            </div>
            <?php echo $form->error($model,"email_content",array("class"=>"parsley-custom-error-message"));?>
        </div>
    </div>
</div>           
<div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="js:history.go(-1);"><?php echo common::translateText("CANCEL_BTN_TEXT");?></button>
<button type="submit" class="btn btn-primary"><?php echo common::translateText("SUBMIT_BTN_TEXT");?></button>
</div>
<?php $this->endWidget(); ?>
<link rel="stylesheet" href="<?php echo Yii::app()->params->ADMIN_BT_URL;?>plugins/summernote/css/summernote.min.css">
<script type="text/javascript" src="<?php echo Yii::app()->params->ADMIN_BT_URL;?>plugins/summernote/js/summernote.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->ADMIN_BT_URL;?>javascript/forms/wysiwyg.js"></script>
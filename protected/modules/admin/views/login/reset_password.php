<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'form-login',
    'focus' => array($model, 'username'),
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    "htmlOptions" => array("class" => "panel", "name" => "form-login")
        ));
?>
<div class="panel-body">
    <!-- Alert message -->
    <div class="alert alert-warning">
        <span class="semibold">Note :</span>&nbsp;&nbsp;Enter Valid Email address  .
    </div>
    <div class="form-group">
        <div class="form-stack has-icon pull-left">
            <?php echo $form->passwordField($model, "password", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("password"))); ?>
            <i class="ico-user2 form-control-icon"></i>
        </div>
    </div>
    <div class="form-group">
        <div class="form-stack has-icon pull-left">
            <?php echo $form->passwordField($model, "repeat_password", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("repeat_password"))); ?>
            <i class="ico-user2 form-control-icon"></i>
        </div>
    </div>

    <!-- Error container -->
    <div id="error-container" class="mb15">
        <?php echo $form->error($model, "email_address", array("class" => "parsley-custom-error-message")); ?>
    </div>
    <!--/ Error container -->
    <div class="form-group nm">
        <button type="submit" class="btn btn-block btn-success"><span class="semibold">Sign In</span></button>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'form-user',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ), 'htmlOptions' => array('enctype' => 'multipart/form-data')));
?>
<div class="row nm">
    <h5 class="semibold mb15">Personal Info:</h5>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model, "first_name", array("class" => "control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model, "first_name", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("first_name"))); ?>
                <i class="ico-user2 form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "first_name", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model, "last_name", array("class" => "control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model, "last_name", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("last_name"))); ?>
                <i class="ico-user2 form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "last_name", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class="row nm">
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model, "email_address", array("class" => "control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model, "email_address", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("email_address"))); ?>
                <i class="ico-envelop form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "email_address", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model, "gender", array("class" => "control-label")); ?>
            <?php echo $form->dropDownList($model, "gender", Users::model()->genderArr, array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control")); ?>  
            <?php echo $form->error($model, "gender", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<!--/ Personal Info  -->
<hr>
<!-- Contact Info  -->
<div class="row nm">
    <h5 class="semibold mb15">Contact Info:</h5>
    <div class="col-md-3">
        <div class="form-group">
            <?php echo $form->labelEx($model, "address", array("class" => "control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textArea($model, "address", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("address"))); ?>
                <i class="ico-map-marker form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "address", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?php echo $form->labelEx($model, "country_id", array("class" => "control-label")); ?>
            <?php
            echo $form->dropDownList($model, "country_id", CHtml::ListData(Countries::model()->getCountries(), 'id', "country"), array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control",
                'ajax' =>
                array('type' => 'POST',
                    'url' => $this->createUrl('common/getstates'), //url to call.
                    'update' => '#Users_state_id', //selector to update
                    'data' => array('id' => 'js:this.value'),
                )
            ));
            ?>  
            <?php echo $form->error($model, "country_id", array("class" => "parsley-custom-error-message")); ?>                                       
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?php echo $form->labelEx($model, "state_id", array("class" => "control-label")); ?>
            <?php echo $form->dropDownList($model, "state_id", CHtml::ListData(States::model()->getStates($model->country_id), "id", "name"), array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control")); ?>  
            <?php echo $form->error($model, "state_id", array("class" => "parsley-custom-error-message")); ?>                                       
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?php echo $form->labelEx($model, "city", array("class" => "control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model, "city", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("city"))); ?>
                <i class="ico-office form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "city", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class="row nm">
    <div class="col-md-3">
        <div class="form-group">
            <?php echo $form->labelEx($model, "zipcode", array("class" => "control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model, "zipcode", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("zipcode"))); ?>
                <i class="ico-bullseye form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "zipcode", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?php echo $form->labelEx($model, "phone_number", array("class" => "control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model, "phone_number", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("phone_number"))); ?>
                <i class="ico-phone2 form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "phone_number", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>

</div>
<!--/ Contact Info  -->    
<hr>    
<!-- Security  -->
<div class="row nm">
    <h5 class="semibold mb15">Security:</h5>
   
    <div class="col-md-6">
        <div class="form-group">
            <?php
            echo $form->labelEx($model, "user_group", array("class" => "control-label"));
            ?>
            <?php echo $form->dropDownList($model, "user_group", CHtml::ListData(UsersGroup::model()->getUsersGroup(), 'id', 'group_name'), array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control")); ?>  
            <?php echo $form->error($model, "user_group", array("class" => "parsley-custom-error-message")); ?>                                       
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model, "status", array("class" => "control-label")); ?>
            <?php echo $form->dropDownList($model, "status", Users::model()->statusArr, array("class" => "form-control")); ?>  
            <?php echo $form->error($model, "status", array("class" => "parsley-custom-error-message")); ?>                                       
        </div>
    </div>
</div>
<?php if ($model->isNewRecord) : ?>
    <div class="row nm">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo $form->labelEx($model, "password", array("class" => "control-label")); ?>
                <div class="has-icon pull-left">
                    <?php echo $form->passwordField($model, "password", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("password"))); ?>
                    <i class="ico-key2 form-control-icon"></i>
                </div>
                <?php echo $form->error($model, "password", array("class" => "parsley-custom-error-message")); ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo $form->labelEx($model, "repeat_password", array("class" => "control-label", "placeholder" => $model->getAttributeLabel("repeat_password"))); ?>
                <div class="has-icon pull-left">
                    <?php echo $form->passwordField($model, "repeat_password", array("class" => "form-control")); ?>
                    <i class="ico-asterisk form-control-icon"></i>
                </div>
                <?php echo $form->error($model, "repeat_password", array("class" => "parsley-custom-error-message")); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<!--/ Security  -->
<hr>
<!-- Photo  -->
<div class="row nm">
    <h5 class="semibold mb15">Profile Photo:</h5>
    <div class="col-md-6">
        <div class="form-group">
            <div>
                <div class="btn-group pr5">
                    <?php $model->profile_pic = !empty($model->profile_pic) ? $model->profile_pic : common::translateText("NOT_AVAILABLE_TEXT"); ?>
                    <img alt="No Image" src="<?php echo Yii::app()->user->getProfilePicture($model->profile_pic, $model->id); ?>" class="img-circle img-bordered"  width="<?php echo Users::THUMB_WIDTH; ?>" height="<?php echo Users::THUMB_HEIGHT; ?>" />
                </div>
                <div class="btn-group">
                    <?php echo $form->fileField($model, "profile_pic"); ?>
                    <?php echo $form->error($model, "profile_pic", array("class" => "parsley-custom-error-message")); ?>
                </div>
            </div>
        </div>
    </div>
</div>                  
<div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="js:history.go(-1);"><?php echo common::translateText("CANCEL_BTN_TEXT"); ?></button>
    <button type="submit" class="btn btn-primary"><?php echo common::translateText("SUBMIT_BTN_TEXT"); ?></button>
</div>
<?php $this->endWidget(); ?>
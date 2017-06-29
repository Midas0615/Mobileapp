<section class="section section-default section-no-border" style="min-height: 510px;">
    <div class="container">
        <?php $this->renderPartial("/layouts/_message"); ?>
        <div class="row">
            <div class="col-md-12 center">
                <h4 class="heading-dark mt-xl"><strong>Signup</strong></h4>
            </div>
        </div>
        <div class="row mb-xl pb-lg">
            <?php $this->renderPartial("//layouts/_message"); ?>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'form-signup',
                "action" => array("/signup/index"),
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'htmlOptions' => array("class" => "col s12"),
                'clientOptions' => array(
                    'validateOnSubmit' => true
                ))
            );
            $model->user_group = UsersGroup::CUSTOMER;
            echo $form->hiddenField($model, "user_group");
            ?>
            <div class="row">
                <div class="col s6">
                    <?php // echo $form->labelEx($model, "first_name"); ?>
                    <?php echo $form->textField($model, "first_name", array("placeholder" => $model->getAttributeLabel("first_name"))); ?>
                    <?php echo $form->error($model, "first_name"); ?>                    
                </div>
                <div class="col s6">
                    <?php // echo $form->labelEx($model, "last_name"); ?>
                    <?php echo $form->textField($model, "last_name", array("placeholder" => $model->getAttributeLabel("last_name"))); ?>
                    <?php echo $form->error($model, "last_name"); ?>                    
                </div>
                <div class="col s6">
                    <?php // echo $form->labelEx($model, "phone_number"); ?>
                    <?php echo $form->textField($model, "phone_number", array("placeholder" => $model->getAttributeLabel("phone_number"))); ?>
                    <?php echo $form->error($model, "phone_number"); ?>                    
                </div>
                <div class="col s6">
                    <?php // echo $form->labelEx($model, "email_address"); ?>
                    <?php echo $form->textField($model, "email_address", array("placeholder" => $model->getAttributeLabel("email_address"))); ?>
                    <?php echo $form->error($model, "email_address"); ?>                    
                </div><div class="col s6">  
                    <?php // echo $form->labelEx($model, "password"); ?>
                    <?php echo $form->passwordField($model, "password", array("placeholder" => $model->getAttributeLabel("password"))); ?>
                    <?php echo $form->error($model, "password"); ?>                    
                </div>    
                <div class="col s6">    
                    <?php // echo $form->labelEx($model, "repeat_password"); ?>
                    <?php echo $form->passwordField($model, "repeat_password", array("placeholder" => $model->getAttributeLabel("repeat_password"))); ?>
                    <?php echo $form->error($model, "repeat_password"); ?>                    
                </div>
                <div class="col s12">
                    <button class="btn waves-effect waves-light red darken-1" type="submit">Signup
                        <i class="mdi-content-send right"></i>
                    </button>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</section>
<section class="section section-default section-no-border" style="min-height: 510px;">
    <div class="container">
        <?php $this->renderPartial("/layouts/_message"); ?>
        <div class="row">
            <div class="col-md-12 center">
                <h4 class="heading-dark mt-xl"><strong>Login</strong></h4>
            </div>
        </div>
        <div class="row mb-xl pb-lg">
            <?php
            $model = new LoginForm;
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'form-login',
                "action" => array("/login/index"),
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'htmlOptions' => array("class" => "cd-form"),
                'clientOptions' => array(
                    'validateOnSubmit' => true
                ))
            );
            ?>
            <div class="row">
                <div class="col s12">
                    <i class="mdi-communication-email prefix white-text"></i>        
                    <?php echo $form->textField($model, "username", array("placeholder" => $model->getAttributeLabel("username"))); ?>
                    <?php echo $form->error($model, "username"); ?>
                    <?php // echo $form->labelEx($model, "username"); ?>
                </div>
                <div class="col s12">
                    <i class="mdi-hardware-desktop-windows prefix white-text"></i>        
                    <?php echo $form->passwordField($model, "password", array("placeholder" => $model->getAttributeLabel("password"))); ?>
                    <?php echo $form->error($model, "password"); ?>
                    <?php // echo $form->labelEx($model, "password"); ?>
                </div>
                <div class="col s12">
                    <a href="<?php echo Yii::app()->createUrl("signup/forgotpassword"); ?>" class="txt-center"><h6 >Forgot Password ?</h6></a>
                </div>
                <div class="col s12">
                    <button class="btn waves-effect waves-light red darken-1" type="submit">Login
                        <i class="mdi-content-send right white-text"></i>
                    </button>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</section>

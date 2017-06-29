<section class="login">
    <article class="container">
        <div class="loginPage">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <?php $this->renderPartial("//layouts/_message"); ?>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'changepassword-form',
                        'enableClientValidation' => true,
                        'htmlOptions' => array("class" => 'login-from'),
                        'enableAjaxValidation' => true,
                        'errorMessageCssClass' => 'errorMessageForm',
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                    ));
                    ?>
                    <div class="row">
                        <div class="col-md-12 center">
                            <h2 class="heading-dark mt-xl"><strong>Change Password</strong></h2>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <?php echo $form->label($model, 'password'); ?>
                            <?php echo $form->passwordField($model, 'password', array("placeholder" => 'Password', "class" => "form-control")); ?>
                            <?php echo $form->error($model, 'password'); ?>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <?php echo $form->label($model, 'repeat_password'); ?>
                            <?php echo $form->passwordField($model, 'repeat_password', array("placeholder" => 'Confirm Password', "class" => "form-control")); ?>
                            <?php echo $form->error($model, 'repeat_password'); ?>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-info" value="Change Password">
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </article> 
</section>   

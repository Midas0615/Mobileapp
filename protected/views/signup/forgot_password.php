<section class="section section-default section-no-border" style="min-height: 510px;">
    <div class="container">
        <?php $this->renderPartial("/layouts/_message"); ?>
        <div class="row">
            <div class="col-md-12 center">
                <h4 class="heading-dark mt-xl"><strong>Forgot Password</strong></h4>
            </div>
        </div>
        <div class="row mb-xl pb-lg">
            <?php $this->renderPartial("//layouts/_message"); ?>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'forgot-form',
                'enableClientValidation' => true,
                'htmlOptions' => array("class" => 'login-from'),
                'enableAjaxValidation' => true,
                'errorMessageCssClass' => 'errorMessageForm',
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
            <div class="form-group">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <?php echo $form->textField($model, 'email_address', array("placeholder" => 'Provide your register email address to continue...', "class" => "form-control")); ?>
                    <?php echo $form->error($model, 'email_address'); ?>
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-info" value="Send Confirmation Link">
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</section>
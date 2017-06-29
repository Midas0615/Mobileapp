<section class="section section-default section-no-border" style="min-height: 510px;">
    <div class="container">
        <?php $this->renderPartial("/layouts/_message"); ?>
        <div class="row">
            <div class="col-md-12 center">
                <h4 class="heading-dark mt-xl"><strong>Change Password</strong></h4>
            </div>
        </div>
        <div class="row mb-xl pb-lg">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'form-password',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'htmlOptions' => array("class" => "cd-form"),
                'clientOptions' => array(
                    'validateOnSubmit' => true
                ))
            );
            ?>
            <div class="row nm">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($model, "password",array("class"=>"label-control")); ?>
                    <?php echo $form->passwordField($model, "password", array("class" => "form-control")); ?>
                    <?php echo $form->error($model, "password"); ?>
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="row nm">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($model, "repeat_password",array("class"=>"label-control")); ?>
                    <?php echo $form->passwordField($model, "repeat_password", array("class" => "form-control")); ?>
                    <?php echo $form->error($model, "repeat_password"); ?>
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="col-md-12 center">
                <div class="row">
                    <button type="submit" class="btn btn-primary" style="margin-top:30px;">Change Password</button>  
                </div>       
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</section>
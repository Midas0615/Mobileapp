
<div class="container-fluid">
    <!-- START row -->
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- START panel -->
            <div class="panel panel-default">
                <!-- panel heading/header -->
                <div class="panel-heading">
                    <h3 class="panel-title">Change Password</h3>
                </div>
                <!--/ panel heading/header -->
                <!-- panel body -->
                <div class="panel-body">
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
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $form->labelEx($model, "password", array("class" => "label-control")); ?>
                            <?php echo $form->passwordField($model, "password", array("class" => "form-control")); ?>
                            <?php echo $form->error($model, "password"); ?>
                        </div>

                    </div>              
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $form->labelEx($model, "repeat_password", array("class" => "label-control")); ?>
                            <?php echo $form->passwordField($model, "repeat_password", array("class" => "form-control")); ?>
                            <?php echo $form->error($model, "repeat_password"); ?>
                        </div>

                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary" style="margin-top:30px;">Change Password</button>  
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <!-- panel body -->
            </div>
            <!--/ END form panel -->

        </div>
        <!--/ END row -->
    </div>
    <!--/ END Template Container -->
</div>

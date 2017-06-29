<section class="section section-default section-no-border">
    <div class="container">
        <?php $this->renderPartial("/layouts/_message"); ?>
        <div class="row">
            <div class="col-md-12 center">
                <h4 class="heading-dark mt-xl"><strong>Account</strong></h4>
            </div>
        </div>
        <div class="row mb-xl pb-lg">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'form-profile',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'htmlOptions' => array("class" => "cd-form"),
                'clientOptions' => array(
                    'validateOnSubmit' => true
                ))
            );
            ?>              
            <div class="row">
                <div class="col s6">
                    <?php echo $form->labelEx($model, "first_name", array("class" => "label-control")); ?>
                    <?php echo $form->textField($model, "first_name", array("class" => "form-control")); ?>
                    <?php echo $form->error($model, "first_name"); ?>
                </div>
                <div class="col s6">
                    <?php echo $form->labelEx($model, "last_name", array("class" => "label-control")); ?>
                    <?php echo $form->textField($model, "last_name", array("class" => "form-control")); ?>
                    <?php echo $form->error($model, "last_name"); ?>
                </div>
            </div>              
            <div class="row">
                <div class="col s6">
                    <?php echo $form->labelEx($model, "email_address", array("class" => "label-control")); ?>
                    <?php echo $form->textField($model, "email_address", array("class" => "form-control")); ?>
                    <?php echo $form->error($model, "email_address"); ?>
                </div>
                <div class="col s6">
                    <?php echo $form->labelEx($model, "phone_number", array("class" => "label-control")); ?>
                    <?php echo $form->textField($model, "phone_number", array("class" => "form-control")); ?>
                    <?php echo $form->error($model, "phone_number"); ?>
                </div>
            </div>    
            <div class="row">
                <div class="col s6">
                    <?php echo $form->labelEx($model, "address", array("class" => "control-label")); ?>
                    <?php echo $form->textArea($model, "address", array("class" => "form-control")); ?>
                    <?php echo $form->error($model, "address"); ?>
                </div>
                <div class="col s6">
                    <?php echo $form->labelEx($model, "country_id", array("class" => "control-label")); ?>
                    <br />
                    <?php
                    echo common::select2($model, "country_id", CHtml::ListData(Countries::model()->getCountries(), 'id', "country"), array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control",
                        'ajax' =>
                        array('type' => 'POST',
                            'url' => $this->createUrl('common/getstates'), //url to call.
                            'update' => '#Users_state_id', //selector to update
                            'data' => array('id' => 'js:this.value'),
                        )
                    ));
                    ?>  
                    <?php echo $form->error($model, "country_id"); ?>
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <?php echo $form->labelEx($model, "state_id", array("class" => "control-label")); ?>
                    <br />
                    <?php echo common::select2($model, "state_id", CHtml::ListData(States::model()->getStates($model->country_id), "id", "name"), array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control")); ?>  
                    <?php echo $form->error($model, "state_id"); ?>                                       
                </div>
                <div class="col s6">
                    <?php echo $form->labelEx($model, "city", array("class" => "control-label")); ?>
                    <?php echo $form->textField($model, "city", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("city"))); ?>
                    <?php echo $form->error($model, "city"); ?>
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <?php echo $form->labelEx($model, "zipcode", array("class" => "control-label")); ?>
                    <?php echo $form->textField($model, "zipcode", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("zipcode"))); ?>
                    <?php echo $form->error($model, "zipcode"); ?>
                </div>
                <div class="col s6">
                    Member Since : <?php echo $model->created_dt; ?>
                    <br />
                    Last Login : <?php echo $model->last_login; ?>
                </div>
            </div>
            <div class="col-md-12 center">
                <div class="row">
                    <button type="submit" class="btn btn-primary" style="margin-top:30px;">Update Profile</button>  
                </div>       
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</section>
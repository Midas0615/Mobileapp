<!-- START Template Container -->
<div class="container-fluid">
    <!-- START row -->
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- START panel -->
            <div class="panel panel-default">
                <!-- panel heading/header -->
                <div class="panel-heading">
                    <h3 class="panel-title">Add Address</h3>
                </div>
                <!--/ panel heading/header -->
                <!-- panel body -->
                <div class="panel-body">
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
                        <div class="col-md-6">
                            <?php echo $form->labelEx($model, "name", array("class" => "label-control")); ?>
                            <?php echo $form->textField($model, "name", array("class" => "form-control")); ?>
                            <?php echo $form->error($model, "name"); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $form->labelEx($model, "address", array("class" => "control-label")); ?>
                            <?php echo $form->textArea($model, "address", array("class" => "form-control")); ?>
                            <?php echo $form->error($model, "address"); ?>
                        </div>
                    </div>              
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $form->labelEx($model, "country_id", array("class" => "control-label")); ?>
                            <br />
                            <?php
                            echo common::select2($model, "country_id", CHtml::ListData(Countries::model()->getCountries(), 'id', "country"), array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control",
                                'ajax' =>
                                array('type' => 'POST',
                                    'url' => $this->createUrl('common/getstates'), //url to call.
                                    'update' => '#UserAddress_state_id', //selector to update
                                    'data' => array('id' => 'js:this.value'),
                                )
                            ));
                            ?>  
                            <?php echo $form->error($model, "country_id"); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $form->labelEx($model, "state_id", array("class" => "control-label")); ?>
                            <br />
                            <?php echo common::select2($model, "state_id", CHtml::ListData(States::model()->getStates($model->country_id), "id", "name"), array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control")); ?>  
                            <?php echo $form->error($model, "state_id"); ?>                                       
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $form->labelEx($model, "city", array("class" => "control-label")); ?>
                            <?php echo $form->textField($model, "city", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("city"))); ?>
                            <?php echo $form->error($model, "city"); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $form->labelEx($model, "zipcode", array("class" => "control-label")); ?>
                            <?php echo $form->textField($model, "zipcode", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("zipcode"))); ?>
                            <?php echo $form->error($model, "zipcode"); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $form->labelEx($model, "is_default", array("class" => "control-label")); ?>
                            <?php echo $form->checkBox($model, "is_default", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("is_default"))); ?>
                            <?php echo $form->error($model, "is_default"); ?>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary" style="margin-top:30px;"><?=($model->id)?'Update':"Create" ?></button>  
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <!-- panel body -->
            </div>
            <!--/ END form panel -->
            <div class="panel panel-default">
                <!-- panel heading/header -->
                <div class="panel-heading">
                    <h3 class="panel-title">Your Addresses</h3>
                </div>
                <!--/ panel heading/header -->
                <!-- panel body -->
                <div class="panel-body">

                    <?php foreach ($data as $val) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <?php if ($val->is_default) { ?>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Your Default Address</h3>
                                        </div>
                                    <?php } else { ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Address</h3>
                                            </div>
                                        <?php } ?>
                                        <!-- panel heading/header -->

                                        <!--/ panel heading/header -->
                                        <!-- panel body -->
                                        <div class="panel-body">
                                            <strong>Name : </strong><?= $val->name ?> <br>
                                            <strong>Address : </strong><?= $val->address ?> <br>
                                            <strong>Country : </strong><?= $val->countryRel->country ?> <br>
                                            <strong>State : </strong><?= $val->stateRel->name ?> <br>
                                            <strong>City : </strong><?= $val->city ?> <br>
                                            <strong>Zip-code : </strong><?= $val->zipcode ?> <br>

                                            <a href="<?= Yii::app()->params["WEB_URL"] ?>admin/users/updateaddress/<?= $val->id ?>"><button  class="btn btn-primary" style="margin-top:30px;">Update </button></a>
                                            <a href="<?= Yii::app()->params["WEB_URL"] ?>admin/users/deleteaddress/<?= $val->id ?>"><button  class="btn btn-danger" style="margin-top:30px;">Delete </button></a>
                                        </div>
                                    </div>
                                </div>              
                            </div>    
                        <?php } ?>

                    </div>
                    <!-- panel body -->
                </div>
            </div>
        </div>
        <!--/ END row -->
    </div>
    <!--/ END Template Container -->
</div>

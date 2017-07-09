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
                    <h3 class="panel-title">Product Detail</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            Product Name :
                        </div>
                        <div class="col-md-6">
                            <?= $model->title ?>
                        </div>
                    </div> 
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            Product Description :
                        </div>
                        <div class="col-md-6">
                            <?= $model->description ?>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            Product Long Description :
                        </div>
                        <div class="col-md-6">
                            <?= $model->long_description ?>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            Product Price :
                        </div>
                        <div class="col-md-6">
                            <?= $model->price ?>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            Product Vendor :
                        </div>
                        <div class="col-md-6">
                            <?= $model->vendorRel->name ?>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            Location :
                        </div>
                        <div class="col-md-6">
                            <?= $model->location ?>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            Status :
                        </div>
                        <div class="col-md-6">
                            <?= $model->statusArr[$model->status] ?>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            Created Date :
                        </div>
                        <div class="col-md-6">
                            <?= common::getDateTimeFromTimeStamp($model->created_dt, 'd/m/Y') ?>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            Updated Date :
                        </div>
                        <div class="col-md-6">
                            <?= common::getDateTimeFromTimeStamp($model->updated_dt, 'd/m/Y') ?>
                        </div>
                    </div>


                </div>
                <!-- panel body -->
            </div>
            <!--/ END form panel -->
            <div class="panel panel-default">
                <!-- panel heading/header -->
                <div class="panel-heading">
                    <h3 class="panel-title">Product Reviews</h3>
                </div>
                <div class="panel-body">
                   
                    <?php foreach ($model->reviewRel as $val) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Review</h3>
                                    </div>
                                    <div class="panel-body">
                                        <strong>Address : </strong><?= $val->comments ?> <br>
                                        <!--<a href="<?= Yii::app()->params["WEB_URL"] ?>admin/users/updateaddress/<?= $val->id ?>"><button  class="btn btn-primary" style="margin-top:30px;">Update </button></a>-->
                                        <!--<a href="<?= Yii::app()->params["WEB_URL"] ?>admin/users/deleteaddress/<?= $val->id ?>"><button  class="btn btn-danger" style="margin-top:30px;">Delete </button></a>-->
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
<div class="btn-group pr5">
    <?php $model->photo = !empty($model->photo) ? $model->photo : common::translateText("NOT_AVAILABLE_TEXT"); ?>
    <img alt="No Image" src="<?php echo $model->getImage($model->photo, $model->id); ?>" class="img-circle img-bordered"  width="<?php echo Users::THUMB_WIDTH; ?>" height="<?php echo Users::THUMB_HEIGHT; ?>" />
</div>

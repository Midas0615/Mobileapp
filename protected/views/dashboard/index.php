<section style="min-height: 480px;">
    <div class="container">
        <?php $this->renderPartial("/layouts/_message"); ?>
        <div class="row">
            <div class="col-md-12 center">
                <h4>Dashboard</h4>
            </div>
        </div>
        <div class="row mb-xl pb-lg">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title"><i class="ico-file mr5"></i>Postings</h5>
                </div>
                <ul class="list-group">
                    <?php// $Posts = new Posts; ?>
                    <li class="list-group-item">Total <span class="semibold pull-right"><?php //echo $Posts->countPostByField(null,null,Yii::app()->user->id); ?></span></li>
                    <li class="list-group-item">Draft <span class="semibold pull-right"><?php //echo $Posts->countPostByField("status", Posts::DRAFT,Yii::app()->user->id); ?></span></li>
                    <li class="list-group-item">New <span class="semibold pull-right"><?php //echo $Posts->countPostByField("status", Posts::PENDING_FOR_APPROVAL,Yii::app()->user->id); ?></span></li>
                    <li class="list-group-item">Disabled <span class="semibold pull-right"><?php //echo $Posts->countPostByField("status", Posts::DISABLED,Yii::app()->user->id); ?></span></li>
                    <li class="list-group-item">Published <span class="semibold pull-right"><?php //echo $Posts->countPostByField("status", Posts::PUBLISHED,Yii::app()->user->id); ?></span></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<ul class="list-table mb15">
    <?php if (!empty($model)): ?>
        <li class="text-right">
            <?php echo CHtml::image(Yii::app()->user->getProfilePicture($model->profile_pic, $model->id), "No Image", array("class" => "img-circle img-bordered", "width" => "20%", "height" => "20%")); ?>
        </li>
        <li class="text-left">
            <h5 class="semibold ellipsis mb0"><?php echo $model->full_name; ?></h5>
            <p class="nm text-muted">Mo. <?php echo $model->phone_number; ?></p>
            <p><?php echo $model->getAddressFormat($model);?></p>
        </li>
    <?php else: ?>
        <li class="text-center">
            <p>No person found.</p>
        </li>
    <?php endif; ?>
</ul>
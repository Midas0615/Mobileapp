<ul class="list-table mb15">
    <?php if (!empty($model)): ?>
        <li class="text-left">
            <?php echo CHtml::image(Yii::app()->user->getProfilePicture($model->profile_pic, $model->id),"No Image",array("class"=>"img-circle img-bordered")); ?>
        </li>
        <li class="text-left">
            <h5 class="semibold ellipsis mb0">Alpesh Vaghela</h5>
            <p class="nm text-muted">Mo. +8734947948</p>
            <p>9, Ambedkar society, BH Market yard, Railway east kalol.</p>
        </li>
    <?php else: ?>
        <li class="text-left">
            <p>No person found.</p>
        </li>
    <?php endif; ?>
</ul>
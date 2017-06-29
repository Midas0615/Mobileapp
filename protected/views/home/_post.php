<div class="col s12 m4 l4">
    <div class="card">
        <div class="card-image waves-effect waves-block waves-light" style="min-height: 317px;">
            <img class="activator" src="<?php echo $data->getImage($data->image, $data->id); ?>">
        </div>
        <div class="card-content">
            <span class="card-title activator grey-text text-darken-4">
                <?php echo $data->title; ?>
                <i class="mdi-navigation-more-vert right"></i>
            </span>
            <p>
                <?php if (!empty($data->link)): ?>
                    <a href="<?php echo $data->link; ?>" target="_blank">Project link</a>
                <?php endif; ?>
            </p>
        </div>
        <div class="card-reveal">
            <span class="card-title grey-text text-darken-4">
                <?php echo $data->title; ?>
                <i class="mdi-navigation-close right"></i>
            </span>
            <p><?php echo $data->description; ?></p>
        </div>
    </div>
</div>
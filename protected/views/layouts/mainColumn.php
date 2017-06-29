<?php $this->beginContent('/layouts/main'); ?>
<?php $this->widget("HeaderMenu"); ?>
<?php echo $content; ?>
<?php $this->widget("FooterMenu"); ?>
<?php $this->endContent(); ?>
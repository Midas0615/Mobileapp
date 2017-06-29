<?php
$this->beginContent('/layouts/main'); ?>
<?php $this->widget("TopMenu"); ?>
<?php $this->widget("LeftMenu"); ?>
<!-- START Template Main -->
<section id="main" role="main">
<!-- START row --><?php echo $content; ?> <!--/ END row --> 
</section>
<section id="modalContainer"></section>
 <?php //$this->widget("RightMenu"); ?>
<!--/ END Template Main -->
<?php $this->endContent();  ?>
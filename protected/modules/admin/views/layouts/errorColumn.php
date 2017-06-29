<?php
$this->beginContent('/layouts/errorMain'); ?>
<!-- START Template Main -->
<section id="main" role="main">
    <!-- START Template Container -->
    <section class="container animation delay animating fadeInDown">
        <!-- START row --> <?php echo $content; ?><!--/ END row -->
    </section>
    <!--/ END Template Container -->
</section>
<!--/ END Template Main -->
<?php $this->endContent();  ?>
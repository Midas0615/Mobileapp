<?php
$this->renderPartial("/layouts/_message");
?>
<!--Hero-->
<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        <h1 class="text_h center header cd-headline letters type">
            <span>I Love</span> 
            <span class="cd-words-wrapper waiting">
                <b class="is-visible">creating</b>
                <b>designing</b>
                <b>developing</b>
            </span>
        </h1>
    </div>
</div>

<!--Intro and service-->
<div id="intro" class="section scrollspy">
    <div class="container">
        <div class="row">
            <div  class="col s12">
                <h4 class="center header text_h4"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. <span class="span_h4"> Phasellus  </span>vestibulum lorem risus, nec suscipit lorem <span class="span_h4"> laoreet quis.</span> </h4>
            </div>
            <div  class="col s12 m4 l4">
                <div class="center promo promo-example">
                    <i class="mdi-image-flash-on"></i>
                    <h5 class="promo-caption">Speeds up development</h5>
                    <p class="light center">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Cum sociis natoque penatibus et magnis dis parturient montes.</p>
                </div>
            </div>
            <div class="col s12 m4 l4">
                <div class="center promo promo-example">
                    <i class="mdi-social-group"></i>
                    <h5 class="promo-caption">User Experience Focused</h5>
                    <p class="light center">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                </div>
            </div>
            <div class="col s12 m4 l4">
                <div class="center promo promo-example">
                    <i class="mdi-hardware-desktop-windows"></i>
                    <h5 class="promo-caption">Fully responsive</h5>
                    <p class="light center">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Work-->
<?php if (!empty($dataProvider)): ?>
    <div class="section scrollspy" id="work">
        <div class="container">
            <h4 class="header text_b">Posts </h4>
            <div class="row">
                <?php $form = $this->beginWidget('CActiveForm', array("method" => "GET", "id" => "search_form", "htmlOptions" => array("onSubmit" => "return false"))); ?>
                <div class="col s10">
                    <?php
                    $this->widget('ext.autocomplete.AutoComplete', array(
                        'theme' => 'facebook',
                        'name' => 'searchPost',
                        'sourceUrl' => Yii::app()->createUrl('home'),
                        'hintText' => 'Please type your need.',
                        'htmlOptions' => array('class' => 'form-control', 'placeholder' => 'Search')
                    ));
                    ?>
                </div>
                <div class="col s2" style="margin-top: 15px;">
                    <button class="btn btn-primary pull-right"><i class="ico-loop4 mr5"></i>Search</button>
                </div>
                <?php $this->endWidget(); ?>
            </div>
            <div class="row">
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'id' => 'post-grid',
                    'dataProvider' => $dataProvider,
                    'itemView' => '_post',
                    'summaryText' => FALSE
                ));
                Yii::app()->clientScript->registerScript('search', "
                    $('#search_form').submit(function(){
                        $.fn.yiiListView.update('post-grid', {
                            data: $('#search_form').serialize()
                        });
                        return false;
                    });
                ");
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<!--Parallax-->
<div class="parallax-container">
    <div class="parallax"><img src="<?php echo Yii::app()->params->FRONT_BT_URL; ?>img/parallax1.png"></div>
</div>

<!--Team-->
<div class="section scrollspy" id="team">
    <div class="container">
        <h4 class="header text_b"> Our Team </h4>
        <div class="row">
            <div class="col s12 m3">
                <div class="card card-avatar">
                    <div class="waves-effect waves-block waves-light">
                        <img class="activator" src="<?php echo Yii::app()->params->FRONT_BT_URL; ?>img/avatar1.png">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Flash <br/>
                            <small><em><a class="red-text text-darken-1" href="#">CEO</a></em></small></span>
                        <p>
                            <a class="blue-text text-lighten-2" href="https://www.facebook.com/joash.c.pereira">
                                <i class="fa fa-facebook-square"></i>
                            </a>
                            <a class="blue-text text-lighten-2" href="https://twitter.com/im_joash">
                                <i class="fa fa-twitter-square"></i>
                            </a>
                            <a class="blue-text text-lighten-2" href="https://plus.google.com/u/0/+JoashPereira">
                                <i class="fa fa-google-plus-square"></i>
                            </a>
                            <a class="blue-text text-lighten-2" href="https://www.linkedin.com/in/joashp">
                                <i class="fa fa-linkedin-square"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m3">
                <div class="card card-avatar">
                    <div class="waves-effect waves-block waves-light">
                        <img class="activator" src="<?php echo Yii::app()->params->FRONT_BT_URL; ?>img/avatar2.png">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Cat Woman<br/>
                            <small><em><a class="red-text text-darken-1" href="#">Designer</a></em></small>
                        </span>
                        <p>
                            <a class="blue-text text-lighten-2" href="https://www.facebook.com/joash.c.pereira">
                                <i class="fa fa-facebook-square"></i>
                            </a>
                            <a class="blue-text text-lighten-2" href="https://twitter.com/im_joash">
                                <i class="fa fa-twitter-square"></i>
                            </a>
                            <a class="blue-text text-lighten-2" href="https://plus.google.com/u/0/+JoashPereira">
                                <i class="fa fa-google-plus-square"></i>
                            </a>
                            <a class="blue-text text-lighten-2" href="https://www.linkedin.com/in/joashp">
                                <i class="fa fa-linkedin-square"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m3">
                <div class="card card-avatar">
                    <div class="waves-effect waves-block waves-light">
                        <img class="activator" src="<?php echo Yii::app()->params->FRONT_BT_URL; ?>img/avatar3.png">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">
                            Capt. America <br/>
                            <small><em><a class="red-text text-darken-1" href="#">CMO</a></em></small></span>
                        <p>
                            <a class="blue-text text-lighten-2" href="https://www.facebook.com/joash.c.pereira">
                                <i class="fa fa-facebook-square"></i>
                            </a>
                            <a class="blue-text text-lighten-2" href="https://twitter.com/im_joash">
                                <i class="fa fa-twitter-square"></i>
                            </a>
                            <a class="blue-text text-lighten-2" href="https://plus.google.com/u/0/+JoashPereira">
                                <i class="fa fa-google-plus-square"></i>
                            </a>
                            <a class="blue-text text-lighten-2" href="https://www.linkedin.com/in/joashp">
                                <i class="fa fa-linkedin-square"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m3">
                <div class="card card-avatar">
                    <div class="waves-effect waves-block waves-light">
                        <img class="activator" src="<?php echo Yii::app()->params->FRONT_BT_URL; ?>img/avatar4.png">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">Robin<br/>
                            <small><em><a class="red-text text-darken-1" href="#">Developer</a></em></small></span>
                        <p>
                            <a class="blue-text text-lighten-2" href="https://www.facebook.com/joash.c.pereira">
                                <i class="fa fa-facebook-square"></i>
                            </a>
                            <a class="blue-text text-lighten-2" href="https://twitter.com/im_joash">
                                <i class="fa fa-twitter-square"></i>
                            </a>
                            <a class="blue-text text-lighten-2" href="https://plus.google.com/u/0/+JoashPereira">
                                <i class="fa fa-google-plus-square"></i>
                            </a>
                            <a class="blue-text text-lighten-2" href="https://www.linkedin.com/in/joashp">
                                <i class="fa fa-linkedin-square"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

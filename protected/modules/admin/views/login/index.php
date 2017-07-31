<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'form-login',
    'focus' => array($model, 'username'),
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => 'js:function(form,data,hasError)
            {
                if(!hasError && form.parsley().validate()) 
                {
                    form.prop("disabled", true);                           
                    NProgress.start();  // start nprogress bar
                    setTimeout(function () {                                
                        NProgress.done(); // done nprogress bar
                        document.getElementById("form-login").submit();
                    }, 500);
                }
                else {
                    // toggle animation
                    form
                    .removeClass("animation animating shake")
                    .addClass("animation animating shake")
                    .one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function () {
                        $(this).removeClass("animation animating shake");
                    });
                }
                // prevent default
                //e.preventDefault();
            }'
    ),
    "htmlOptions" => array("class" => "panel", "name" => "form-login")
        ));
?>
<div class="panel-body">
    <!-- Alert message -->
    <div class="alert alert-warning">
        <span class="semibold">Note :</span>&nbsp;&nbsp;Please login with your correct credentials  .
    </div>
    <div class="form-group">
        <div class="form-stack has-icon pull-left">
            <input name="AdminLoginForm[username]" id="AdminLoginForm_username" type="text" class="form-control input-lg" placeholder="Email" data-parsley-errors-container="#error-container" data-parsley-error-message="" data-parsley-required>
            <i class="ico-user2 form-control-icon"></i>
        </div>
        <div class="form-stack has-icon pull-left">
            <input name="AdminLoginForm[password]" id="AdminLoginForm_password" type="password" class="form-control input-lg" placeholder="Password" data-parsley-errors-container="#error-container" data-parsley-error-message="" data-parsley-required>
            <i class="ico-lock2 form-control-icon"></i>
        </div>
    </div>

    <!-- Error container -->
    <div id="error-container" class="mb15">
        <?php echo $form->error($model, "username", array("class" => "parsley-custom-error-message")); ?>
        <?php echo $form->error($model, "password", array("class" => "parsley-custom-error-message")); ?>
    </div>
    <!--/ Error container -->

    <div class="form-group">
        <div class="row">
            <div class="col-xs-6">
                <div class="checkbox custom-checkbox">  
                    <?php echo $form->checkBox($model, "rememberMe") ?>
                    <label for="AdminLoginForm_rememberMe">&nbsp;&nbsp;Remember me</label>
                </div>
            </div>
            <div class="col-xs-6">
                <?php //echo CHtml::Link('Forgot Password', array("login/forgotpassword")); ?>
            </div>
        </div>
    </div>
    <div class="form-group nm">
        <button type="submit" class="btn btn-block btn-success"><span class="semibold">Sign In</span></button>
    </div>
</div>
<?php $this->endWidget(); ?>
<!-- Login form -->
<!--<hr>
<p class="text-muted text-center">Do you want to register ? 
    <?php //echo CHtml::Link("Sign up to get started", array("login/signup"), array("class" => "semibold")); ?>
</p>-->

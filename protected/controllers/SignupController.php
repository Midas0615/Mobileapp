<?php

class SignupController extends FrontController {

    public $layout = "mainColumn";

    public function actionIndex() {
        $model = new Users("signup");
        if (isset($_POST['Users'])) {

            $model->attributes = $_POST['Users'];
            $model->username = $model->email_address;
            $model->repeat_password = $model->password;
            $model->status = Users::IN_ACTIVE;

            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model, "form-signup");
            if ($model->validate()) {
                $model->access_token = common::generateAccessToken();
                $model->save();
                $this->sendSigupEMail($model);
                Yii::app()->user->setFlash("success", common::translateText("REGISTER_SUCCESS"));
            } else {
                Yii::app()->user->setFlash("danger", "Invalid access of the system.");
            }
            $this->redirect(Yii::app()->createUrl("signup"));
        }
        $this->render("_form", array("model" => $model));
    }

    public function sendSigupEMail($model) {
        $SendMail = new SendMail("CUSTOMER_REGISTRATION");
        $SendMail->EMAIL_TAGS = array(
            "[RECEIVER_NAME]" => $model->first_name . " " . $model->last_name,
            "[LINK]" => CHtml::Link("Click here to verify you account", Yii::app()->params->WEB_URL . "signup/verify?access_token=" . $model->access_token)
        );
        $SendMail->EMAIL_TO[] = $model->email_address;
        $SendMail->send();
    }

    public function actionVerify() {
        $access_token = !empty($_GET["access_token"]) ? $_GET["access_token"] : "";
        $model = Users::model()->findByAttributes(array("access_token" => trim($access_token)));

        if (!empty($access_token) && !empty($model)) {
            if ($model->status == Users::IN_ACTIVE) {
                $model->status = Users::ACTIVE;
                $model->is_verified = Users::VERIFIED;
                $model->access_token = null;
                $model->update(false);
                Yii::app()->user->setFlash("success", common::translateText("ACCOUNT_VERIFIED_SUCCESS"));
            } else {
                Yii::app()->user->setFlash("danger", common::translateText("ACCOUNT_VERIFIED_SUCCESS_ALREADY"));
            }
        } else {
            Yii::app()->user->setFlash("danger", "Invalid access.");
        }
        $this->redirect(Yii::app()->createUrl("signup"));
    }

    public function actionForgotPassword() {
        $model = new Users("forgot_password");
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'forgot-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            $model = Users::model()->findByAttributes(array("email_address" => $model->email_address));
            if (!empty($model)) {
                $model->access_token = common::generateAccessToken();
                $model->update(false);
                $this->forgetPasswordEmail($model);
                Yii::app()->user->setFlash("success", "Change Password link has been sent on your email.");
                $this->redirect(Yii::app()->createUrl("login"));
            }
        }
        $this->render('forgot_password', array('model' => $model));
    }

    public function forgetPasswordEmail($model) {
        $LINK = Yii::app()->params->WEB_URL . "signup/changepassword?access_token=" . $model->access_token;
        $SendMail = new SendMail("FORGOT_PASSWORD");
        $SendMail->EMAIL_TAGS = array(
            "[RECEIVER_NAME]" => $model->first_name . " " . $model->last_name,
            "[LINK]" => CHtml::Link("Click here to change your password", $LINK)
        );
        $SendMail->EMAIL_TO[] = $model->email_address;
        $SendMail->send();
    }

    public function actionChangePassword() {
        $access_token = !empty($_GET["access_token"]) ? $_GET["access_token"] : "";
        $model = Users::model()->findByAttributes(array("access_token" => trim($access_token)));

        if (!empty($access_token) && !empty($model)) {

            $model->scenario = "change_password";
            if (isset($_POST['Users'])) {
                $model->attributes = $_POST['Users'];
                if (isset($_POST['ajax']) && $_POST['ajax'] === 'changepassword-form') {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
                }
                if ($model->validate()) {
                    $model->salt = $model->generateSalt();
                    $model->password = $model->hashPassword($model->password, $model->salt);
                    $model->repeat_password = $model->password;
                    $model->access_token = null;
                    $model->update(false);
                    //$this->passwordChangedEmail($model);
                    Yii::app()->user->setFlash("success", "Your password has been changed successfully, Please login.");
                    $this->redirect("signup");
                }
            }
        } else {
            Yii::app()->user->setFlash("danger", "Invalid access.");
            $this->redirect(Yii::app()->createUrl("signup"));
        }
        $model->password = $model->repeat_password = "";
        $this->render('change_password', array('model' => $model));
    }

    public function passwordChangedEmail($model) {

        $SendMail = new SendMail("PASSWORD_CHANGED");
        $SendMail->EMAIL_TAGS = array(
            "[RECEIVER_NAME]" => $model->first_name . " " . $model->last_name,
        );
        $SendMail->EMAIL_TO[] = $model->email;
        $SendMail->send();
    }

}

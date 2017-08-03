<?php

class LoginController extends BackendController {

    public $layout = "loginColumn";

    public function actionIndex() {
        $model = new AdminLoginForm;
        Yii::app()->user->returnUrl = Yii::app()->createUrl("" . Yii::app()->controller->module->id . "/dashboard");

        if (Users::model()->isAdminLoggedIn()) {
            $this->redirect(Yii::app()->user->returnUrl);
        }

        // collect user input data
        if (isset($_POST['AdminLoginForm'])) {

            $model->attributes = $_POST['AdminLoginForm'];
            $this->performAjaxValidation($model, "form-login");
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('index', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        unset($_SESSION["is_backend_login"]);
        $this->redirect(Yii::app()->user->loginUrl);
    }

    public function actionForgotpassword() {
        $model = new Users();
        if (Users::model()->isAdminLoggedIn()) {
            $this->redirect(Yii::app()->user->returnUrl);
        }
        if (isset($_POST['Users'])) {
            $Criteria = new CDbCriteria();
            $Criteria->compare('email_address', $_POST['Users']['email_address']);
            $modelData = Users::model()->find($Criteria);
            $modelData->password_reset_token = bin2hex(openssl_random_pseudo_bytes(16));
            $modelData->save();
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: A Life\'s Invetory <ladanidipak2014@gmail.com>' . "\r\n";
            $htmlContent = Yii::app()->params['WEB_URL'] . 'admin/login/resetpassword?password_reset_token=' . $modelData->password_reset_token;
            $isAdminMailSend = mail($modelData->email_address, 'Password Reset', $htmlContent, $headers);
            $SendMail = new SendMail("FORGOT_PASSWORD");
            $SendMail->EMAIL_TAGS = array(
                "[RECEIVER_NAME]" => 'Dipak',
                "[LINK]" => $htmlContent,
            );
            $SendMail->EMAIL_TO[] = $modelData->email_address;
            $flag = $SendMail->send();
            $this->redirect(Yii::app()->user->returnUrl);
        }
        $this->render('forgot_password', array('model' => $model));
    }

    public function actionResetpassword() {
        $model = new Users();
        if (isset($_GET['password_reset_token']) && $_POST['Users']) {
            $Criteria = new CDbCriteria();
            $Criteria->compare('password_reset_token', $_GET['password_reset_token']);
            $modelData = Users::model()->find($Criteria);
            $modelData->password = $_POST['Users']['password'];
            $modelData->salt = Users::model()->generateSalt();
            $modelData->password = Users::model()->hashPassword($modelData->password, $modelData->salt);
            $modelData->repeat_password = $modelData->password;
            $modelData->password_reset_token = '';
            $modelData->update();
            $this->redirect(Yii::app()->user->returnUrl);
        }
        $this->render('reset_password', array('model' => $model));
    }

}

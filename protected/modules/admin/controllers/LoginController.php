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

}

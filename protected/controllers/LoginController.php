<?php

class LoginController extends FrontController {

    public $layout = "mainColumn";

    public function actionIndex() {
        $model = new LoginForm;
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            $this->performAjaxValidation($model, "form-login");
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->redirect(array("dashboard/index"));
            } else {
                Yii::app()->user->setFlash("danger", "Invalid credentials");
            }
            $this->redirect("login");
        }
        $this->render("_form", array("model" => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        unset($_SESSION["is_front_login"]);
        $this->redirect(array("home/index"));
    }

}

<?php

class AccountController extends Controller {

    public $layout = "mainColumn";

    public function actionIndex() {
        $model = $this->loadModel(Yii::app()->user->id, "Users");
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $this->performAjaxValidation($model, "form-profile");
            if ($model->validate()) {
                $model->update(false);
                Yii::app()->user->setFlash("success", "Your profie has been updated successfully.");
                $this->redirect(array("/account/index"));
            }
        }
        $this->render('index', array('model' => $model));
    }

    public function actionChangePassword() {
        $model = $this->loadModel(Yii::app()->user->id, "Users");
        $model->scenario = "change_password";
        $model->password = "";
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $this->performAjaxValidation($model, "form-password");
            if ($model->validate()) {
                $model->salt = $model->generateSalt();
                $model->password = $model->hashPassword($model->password, $model->salt);
                $model->update(false);
                Yii::app()->user->setFlash("success", "Your password has been updated successfully.");
                $this->redirect(array("/account/changepassword"));
            }
        }
        $this->render('change_password', array('model' => $model));
    }

}

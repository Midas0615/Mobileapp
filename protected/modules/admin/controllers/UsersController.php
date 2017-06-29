<?php

class UsersController extends Controller {
    /* View lising page */

    public function actionIndex() {
        $model = new Users("search");
        if (isset($_GET['Users'])) {
            $model->attributes = $_GET['Users'];
        }
        $this->render('index', array("model" => $model));
    }

    /* add user group */

    public function actionAdd() {

        $model = new Users('add');
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-user");

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->validate()) {
                $model->save();
                $model->profile_pic = $model->uploadProfilePicture($model);
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
                $this->redirect(array("/".Yii::app()->controller->module->id."/users"));
            }
        }
        $this->render('addUser', array('model' => $model));
    }

    /* update user group */

    public function actionUpdate($id) {
        $model = $this->loadModel($id, "Users");
        $old_profile_pic = $model->profile_pic;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-user");
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->validate()) {
                $model->profile_pic = $model->uploadProfilePicture($model);
                $model->profile_pic = !empty($model->profile_pic) ? $model->profile_pic : $old_profile_pic;
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
                $this->redirect(array("/".Yii::app()->controller->module->id."/users"));
            }
        }
        $this->render('updateUser', array('model' => $model));
    }

    /* delete user group */

    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id, "Users");
            $model->deleted = true;
            if ($model->update()) {
                echo common::getMessage("success", common::translateText("DELETE_SUCCESS"));
            } else {
                echo common::getMessage("danger", common::translateText("DELETE_FAIL"));
            }
            Yii::app()->end();
        } else {
            throw new CHttpException(400, common::translateText("400_ERROR"));
        }
    }

    /* view user profile */

    public function actionProfile() {
        $model = $this->loadModel(Yii::app()->user->id, "Users");
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $this->performAjaxValidation($model, "form-profile");
            if ($model->validate()) {
                $model->update(false);
                Yii::app()->user->setFlash("success", "Your profie has been updated successfully.");
                $this->redirect(array("profile"));
            }
        }
        $this->render("profile", array("model" => $model));
    }

}

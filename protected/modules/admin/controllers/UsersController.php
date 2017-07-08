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
                $this->redirect(array("/" . Yii::app()->controller->module->id . "/users"));
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
                $this->redirect(array("/" . Yii::app()->controller->module->id . "/users"));
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

    public function actionAddress() {
        $model = new UserAddress();
        $criteria = new CDbCriteria();
        $criteria->condition = "user_id = " . Yii::app()->user->id;
        $modelData = UserAddress::model()->findAll($criteria);
        if (isset($_POST['UserAddress'])) {
            UserAddress::model()->updateAll(array('is_default'=>0));
            $model->attributes = $_POST['UserAddress'];
            $model->user_id = Yii::app()->user->id;
            $this->performAjaxValidation($model, "form-profile");
            if ($model->validate()) {
                $model->save();
                Yii::app()->user->setFlash("success", "Your profie has been updated successfully.");
                $this->redirect(array("address"));
            } else {
                ob_clean();
                echo "<pre>";
                print_r($model->getErrors());
                exit();
            }
        }
        $this->render("address", array("model" => $model, "data" => $modelData));
    }
    public function actionUpdateaddress($id) {
        $model = UserAddress::model()->findByPk($_REQUEST['id']);
        $criteria = new CDbCriteria();
        $criteria->condition = "user_id = " . Yii::app()->user->id;
        $modelData = UserAddress::model()->findAll($criteria);
        $this->performAjaxValidation($model, 'teams-form');
        if (isset($_POST["UserAddress"])) {
            UserAddress::model()->updateAll(array('is_default'=>0));
            $model->attributes = $_POST["UserAddress"];
            if ($model->validate()) {
                $model->update();
                Yii::app()->user->setFlash('success', 'You have successfully updated record.');
                $this->redirect(array("settings/teams"));
            } else {
                echo "<pre>";
                print_r($model->getErrors());
                die;
            }
        }
        $this->render("address", array("model" => $model, "data" => $modelData));
    }

    public function actionDeleteaddress($id) {
        if (Yii::app()->request->isPostRequest) {
            if (TeamsMaster::model()->checkDelete($id)) {
                // we only allow deletion via POST request
                $model = TeamsMaster::model()->findByPk($id);
                $model->deleted = 1;
                $model->update();
                echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully deleted record.</div>";
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('address'));
            }else {
                echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>This record is co-related to other record so it can not be deleted.</div>";
                Yii::app()->end();
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

}

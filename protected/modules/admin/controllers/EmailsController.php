<?php

class EmailsController extends Controller {


    /* View lising page */

    public function actionIndex() {
        $model = new EmailTemplates("search");
        $this->render('index', array("model" => $model));
    }

    /* add email group */

    public function actionAdd() {

        $model = new EmailTemplates('add');
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-email");

        if (isset($_POST['EmailTemplates'])) {
            $model->attributes = $_POST['EmailTemplates'];
            if ($model->validate()) {
                $model->save();
                Yii::app()->user->setFlash("success", common::translateText( "ADD_SUCCESS"));
                $this->redirect(array("/".Yii::app()->controller->module->id."/emails"));
            }
        }
        $this->render('addEmail', array('model' => $model));
    }

    /* update email */

    public function actionUpdate($id) {
        $model = $this->loadModel($id,"EmailTemplates");
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-email");
        if (isset($_POST['EmailTemplates'])) {
            $model->attributes = $_POST['EmailTemplates'];
            if ($model->validate()) {
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText( "UPDATE_SUCCESS"));
                $this->redirect(array("/".Yii::app()->controller->module->id."/emails"));
            }
        }
        $this->render('updateEmail', array('model' => $model));
    }

    /* delete user group */

    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id,"EmailTemplates");
            $model->deleted = true;
            if ($model->update()) {
                echo common::getMessage("success", common::translateText( "DELETE_SUCCESS"));
            } else {
                echo common::getMessage("danger", common::translateText( "DELETE_FAIL"));
            }
            Yii::app()->end();
        } else {
            throw new CHttpException(400, common::translateText( "400_ERROR"));
        }
    }

    /* view user profile*/

    public function actionLogs() {
        $model = new EmailLogs("search");
        $this->render('logs', array("model" => $model));
    }

}

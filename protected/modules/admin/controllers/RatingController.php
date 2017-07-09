<?php

class RatingController extends Controller {
    /* View lising page */

    public function actionIndex() {
        $model = new Rating("search");
        if (isset($_GET['Rating'])) {
            $model->attributes = $_GET['Rating'];
        }
        $this->render('index', array("model" => $model));
    }

    /* add Rating */

    public function actionAdd() {
        $model = new Rating();
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, $this->id . "-form");
        if (isset($_POST['Rating'])) {
            $model->attributes = $_POST['Rating'];
            $model->star = $_POST['star'];
            if ($model->validate()) {
                $model->save();
                Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
           
                $this->redirect(array("/" . Yii::app()->controller->module->id . "/rating"));
            }
        }
        $this->render('add', array('model' => $model));
    }

    /* update Rating */

    public function actionUpdate($id) {
        $model = $this->loadModel($id, "Rating");
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, $this->id . "-form");
        if (isset($_POST['Rating'])) {
            $model->attributes = $_POST['Rating'];
            $model->star = $_POST['star'];
            if ($model->validate()) {
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
                $this->redirect(array("/" . Yii::app()->controller->module->id . "/rating"));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /* delete Rating */

    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id, "Rating");
            $model->is_deleted = true;
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

}

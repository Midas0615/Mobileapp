<?php

class ReviewController extends Controller {
    /* View lising page */

    public function actionIndex() {
        $model = new Review("search");
        if (isset($_GET['Review'])) {
            $model->attributes = $_GET['Review'];
        }
        $this->render('index', array("model" => $model));
    }

    /* add Review */

    public function actionAdd() {
        $model = new Review();
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, $this->id . "-form");
        if (isset($_POST['Review'])) {
            $model->attributes = $_POST['Review'];
            if ($model->validate()) {
                $model->save();
                Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
           
                $this->redirect(array("/" . Yii::app()->controller->module->id . "/review"));
            }
        }
        $this->render('add', array('model' => $model));
    }

    /* update Review */

    public function actionUpdate($id) {
        $model = $this->loadModel($id, "Review");
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, $this->id . "-form");
        if (isset($_POST['Review'])) {
            $model->attributes = $_POST['Review'];
            if ($model->validate()) {
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
                $this->redirect(array("/" . Yii::app()->controller->module->id . "/review"));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /* delete Review */

    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id, "Review");
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

<?php

class CategoriesController extends Controller {

    /* View lising page */

    public function actionIndex() {
        $model = new Categories("search");
        if (isset($_GET['Categories'])) {
            $model->attributes = $_GET['Categories'];
        }
        $this->render('index', array("model" => $model));
    }

    /* add Categories */

    public function actionAdd() {

        $model = new Categories();
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, $this->id . "-form");

        if (isset($_POST['Categories'])) {
            $model->attributes = $_POST['Categories'];
            if ($model->validate()) {
                $model->save();
                Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
                $this->redirect(array("/".Yii::app()->controller->module->id."/Categories"));
            }
        }
        $this->render('add', array('model' => $model));
    }

    /* update Categories */

    public function actionUpdate($id) {
        $model = $this->loadModel($id, "Categories");
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, $this->id . "-form");
        if (isset($_POST['Categories'])) {
            $model->attributes = $_POST['Categories'];
            if ($model->validate()) {
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
                $this->redirect(array("/".Yii::app()->controller->module->id."/Categories"));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /* delete Categories */

    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id, "Categories");
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

}

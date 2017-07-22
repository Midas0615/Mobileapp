<?php

class OrderController extends Controller {
    /* View lising page */

    public function actionIndex() {
        $model = new Order("search");
        if (isset($_GET['Order'])) {
            $model->attributes = $_GET['Order'];
        }
        $this->render('index', array("model" => $model));
    }
    
    public function actionHistory() {
        $model = new Order("search");
        $model->user_id  = Yii::app()->user->id;
        if (isset($_GET['Order'])) {
            $model->attributes = $_GET['Order'];
        }
        $this->render('index', array("model" => $model));
    }

    /* add Order */

    public function actionAdd() {
        $model = new Order();
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, $this->id . "-form");

        if (isset($_POST['Order'])) {
            $model->attributes = $_POST['Order'];
            if ($model->validate()) {
                $model->save();
                Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
                $this->redirect(array("/" . Yii::app()->controller->module->id . "/Order"));
            }
        }
        $this->render('add', array('model' => $model));
    }

    /* update Order */

    public function actionUpdate($id) {
        $model = $this->loadModel($id, "Order");
        $this->performAjaxValidation($model, $this->id . "-form");
        if (isset($_POST['Order'])) {
            $model->attributes = $_POST['Order'];
            if ($model->validate()) {
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
                $this->redirect(array("/" . Yii::app()->controller->module->id . "/Order"));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /* delete Order */

    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id, "Order");
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

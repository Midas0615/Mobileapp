<?php

class ProductController extends Controller {

    /* View lising page */

    public function actionIndex() {
        $model = new Product("search");
        if (isset($_GET['Product'])) {
            $model->attributes = $_GET['Product'];
        }
        $this->render('index', array("model" => $model));
    }

    /* add Product */

    public function actionAdd() {
        $model = new Product();
        if ($this->isAuthor) {
            $model->author_id = Yii::app()->user->id;
        }
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, $this->id . "-form");

        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            if ($model->validate()) {
                $model->save();
                $model->photo = $model->uploadImage($model);
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
                $this->redirect(array("/".Yii::app()->controller->module->id."/Product"));
            }
        }
        $this->render('add', array('model' => $model));
    }

    /* update Product */

    public function actionUpdate($id) {
        $model = $this->loadModel($id, "Product");
        $old_image = $model->photo;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, $this->id . "-form");
        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            if ($model->validate()) {
                $model->photo = $model->uploadImage($model);
                $model->photo = !empty($model->photo) ? $model->photo : $old_image;
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
                $this->redirect(array("/".Yii::app()->controller->module->id."/Product"));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /* delete Product */

    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id, "Product");
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

<?php

class VendorController extends Controller {
    /* View lising page */

    public function actionIndex() {
        $model = new Vendor("search");
        if (isset($_GET['Vendor'])) {
            $model->attributes = $_GET['Vendor'];
        }
        $this->render('index', array("model" => $model));
    }

    /* add vendor */

    public function actionAdd() {
        $model = new Vendor();
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, $this->id . "-form");

        if (isset($_POST['Vendor'])) {
            $model->attributes = $_POST['Vendor'];
            if ($model->validate()) {
                $model->save();
                $model->photo = $model->uploadImage($model);
                Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
                $this->redirect(array("/" . Yii::app()->controller->module->id . "/vendor"));
            } else {
                ob_clean();
                echo "<pre>";
                print_r($model->getErrors());
                exit();
            }
        }
        $this->render('add', array('model' => $model));
    }

    /* update vendor */

    public function actionUpdate($id) {
        $model = $this->loadModel($id, "Vendor");
        $this->performAjaxValidation($model, $this->id . "-form");
        if (isset($_POST['Vendor'])) {
            $model->attributes = $_POST['Vendor'];
            if ($model->validate()) {
                $model->photo = $model->uploadImage($model);
                $model->photo = !empty($model->photo) ? $model->photo : $old_image;
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
                $this->redirect(array("/" . Yii::app()->controller->module->id . "/vendor"));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /* delete vendor */

    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id, "Vendor");
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

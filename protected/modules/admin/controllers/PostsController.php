<?php

class PostsController extends Controller {

    /* View lising page */

    public function actionIndex() {
        $model = new Posts("search");
        if (isset($_GET['Posts'])) {
            $model->attributes = $_GET['Posts'];
        }
        $this->render('index', array("model" => $model));
    }

    /* add Posts */

    public function actionAdd() {

        $model = new Posts();
        if ($this->isAuthor) {
            $model->author_id = Yii::app()->user->id;
        }
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, $this->id . "-form");

        if (isset($_POST['Posts'])) {
            $model->attributes = $_POST['Posts'];
            if ($model->validate()) {
                $model->save();
                $model->image = $model->uploadImage($model);
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
                $this->redirect(array("/".Yii::app()->controller->module->id."/Posts"));
            }
        }
        $this->render('add', array('model' => $model));
    }

    /* update Posts */

    public function actionUpdate($id) {
        $model = $this->loadModel($id, "Posts");
        $old_image = $model->image;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, $this->id . "-form");
        if (isset($_POST['Posts'])) {
            $model->attributes = $_POST['Posts'];
            if ($model->validate()) {
                $model->image = $model->uploadImage($model);
                $model->image = !empty($model->image) ? $model->image : $old_image;
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
                $this->redirect(array("/".Yii::app()->controller->module->id."/Posts"));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /* delete Posts */

    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id, "Posts");
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

    public function actionStatus($id = null) {
        if (Yii::app()->request->isAjaxRequest) {
            if (!empty($id)):
                $idsArr = array($id);
            else:
                $idsArr = !empty($_POST["idList"]) ? $_POST["idList"] : array();
            endif;

            $update = false;
            if (!empty($idsArr)) : foreach ($idsArr as $id):
                    $model = $this->loadModel($id, "Posts");
                    $model->status = Posts::PUBLISHED;
                    $update = ($model->update()) ? true : false;
                endforeach;
            endif;
            if ($update) {
                echo common::getMessage("success", "You have successfully pulished posts.");
            } else {
                echo common::getMessage("danger", common::translateText("DELETE_FAIL"));
            }
            Yii::app()->end();
        } else {
            throw new CHttpException(400, common::translateText("400_ERROR"));
        }
    }

}

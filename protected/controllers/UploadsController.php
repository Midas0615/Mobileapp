<?php

class UploadsController extends Controller {
    /* View lising page */

    public function actionProductimage() {
        if (isset($_POST['id']) && isset($_FILES['photo'])) {
            $model = Product::model()->findByPk($_POST['id']);
            $uploaddir = Yii::app()->params->paths['productPath'] . $model->id . "/";
            $uploadfile = $uploaddir . basename($_FILES['photo']['name']);
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
                $model->photo = $_FILES['photo']['name'];
                $model->update();
                echo json_encode(array('status' => 1, 'message' => 'Upload file Sucessfully'));
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Problem in uploads'));
            }
        } else {
            echo json_encode(array('status' => 0, 'message' => 'Invalid request'));
        }
    }

    public function actionUserimage() {
        if (isset($_POST['id']) && isset($_FILES['profile_pic'])) {
            $model = Users::model()->findByPk($_POST['id']);
            $uploaddir = Yii::app()->params->paths['usersPath'] . $model->id . "/";
            $uploadfile = $uploaddir . basename($_FILES['profile_pic']['name']);
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadfile)) {
                $model->profile_pic = $_FILES['profile_pic']['name'];
                $model->update();
                echo json_encode(array('status' => 1, 'message' => 'Upload file Sucessfully'));
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Problem in uploads'));
            }
        } else {
            echo json_encode(array('status' => 0, 'message' => 'Invalid request'));
        }
    }

    public function actionVendorimage() {
        if (isset($_POST['id']) && isset($_FILES['photo'])) {
            $model = Vendor::model()->findByPk($_POST['id']);
            $uploaddir = Yii::app()->params->paths['vendorPath'] . $model->id . "/";
            $uploadfile = $uploaddir . basename($_FILES['photo']['name']);
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
                $model->photo = $_FILES['photo']['name'];
                $model->update();
                echo json_encode(array('status' => 1, 'message' => 'Upload file Sucessfully'));
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Problem in uploads'));
            }
        } else {
            echo json_encode(array('status' => 0, 'message' => 'Invalid request'));
        }
    }

}

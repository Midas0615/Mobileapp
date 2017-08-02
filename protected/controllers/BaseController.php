<?php

/**
 *
 * @name    BaseController.php
 * @package application.api.controllers
 * @author  Dipak Ladani
 * @date    10-3-2017
 */
class BaseController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function init() {
        ob_clean();
        echo "<pre>";
        print_r($variable);
        exit();
        $token = Yii::app()->request->getPost('access_token');
        if (Yii::app()->request->isPostRequest && isset($token)) {
            $Criteria = new CDbCriteria();
            $Criteria->compare('token', $token);
            $model = User::model()->find($Criteria);
            if (isset($model->token)) {
                if (!isset($model->token) && $model->token != $token) {
                    $data = ["status" => 2, "message" => 'Sesson timeout please login again'];
                    echo json_encode($data);
                    Yii::app()->end();
                }
            } else {
                $data = ["status" => 2, "message" => 'Sesson timeout please login again'];
                echo json_encode($data);
                Yii::app()->end();
            }
        } else {
            $data = ["status" => 2, "message" => 'Sesson timeout please login again'];
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionIndex() {
        ob_clean();
        echo "<pre>";
        print_r($variable);
        exit();
        
    }

}

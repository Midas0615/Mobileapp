<?php

class ErrorController extends Controller {

    public $layout = "errorColumn";

    public function actionIndex() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else {
                switch ($error['code']) {
                    case 403:
                        $viewFile = "403_forbidden";
                        break;
                    case 500:
                        $viewFile = "403_server_error";
                        break;
                    default:
                        $viewFile = "404_not_found";
                        break;
                }
                $this->render($viewFile, $error);
            }
        }
    }

}

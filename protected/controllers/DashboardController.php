<?php

class DashboardController extends Controller {

    public $layout = "mainColumn";

    public function actionIndex() {
        $this->render('index');
    }

}

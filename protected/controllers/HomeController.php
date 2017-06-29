<?php

class HomeController extends FrontController {

    public $layout = "mainColumn";

    public function actionIndex() {
        $this->redirect(array("admin/index"));
        //$criteria = new CDbCriteria();
        //$criteria->compare("t.status", Posts::PUBLISHED);
        //$criteria->addCondition("t.start_date <= '" . common::getTimeStamp() . "'", 'AND');
        //$criteria->addCondition("t.end_date >= '" . common::getTimeStamp() . "'", 'AND');

        if (isset($_GET['q'])) {
            $q = $_GET['q'];
            $criteria->compare("t.title", $q, true, "LIKE");
            $Posts = Posts::model()->findAll($criteria);
            $array = array();
            if (!empty($Posts)):foreach ($Posts as $Post):
                    $array[] = array('id' => $Post->id, 'name' => $Post->title);
                endforeach;
            endif;
            echo CJSON::encode($array);
            exit;
        }
        if (!empty($_GET['searchPost'])) {
            $criteria->addInCondition("t.id", explode(",", $_GET['searchPost']));
        }
        $dataProvider = new CActiveDataProvider('Posts', array(
            'criteria' => $criteria,
            'pagination' => false, // array( 'pageSize' => Yii::app()->params->defaultPageSize)
        ));
        $model = new Posts();
        $this->render('index', array("dataProvider" => $dataProvider, "model" => $model));
    }

}

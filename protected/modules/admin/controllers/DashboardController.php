<?php

class DashboardController extends Controller {

    public function actionIndex() {
        $criteria = new CDbCriteria;
        $criteria->compare('t.user_id', Yii::app()->user->id);
        $model = Order::model()->findAll($criteria);
        $data = array();
//        ob_clean();
//        echo "<pre>";
//        print_r(date('Y-m-j'));
//        echo "<br>";
//        print_r(common::getDateTimeFromTimeStamp($model[2]->order_date,'Y-d-m'));
//        exit();
        // $i = 0;
        foreach ($model as $val) {
            $data = array('title' => $val->address, 'start' => common::getDateTimeFromTimeStamp($val->order_date, 'Y-d-m'));
            //   $i++;
        }
//        ob_clean();
//        echo "<pre>";
//        print_r($data);
//        exit();
        //common::getDateTimeFromTimeStamp($val->order_date, 'Y-m-j')
        $this->render('index', array('data' => $data));
    }

}

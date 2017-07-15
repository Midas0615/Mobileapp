<?php

class DashboardController extends Controller {

    public function actionIndex() {
        $criteria = new CDbCriteria;
        $model = Order::model()->findAll($criteria);
        $data = array();
        $events = array();
        foreach ($model as $val) {
            $data = array('title' => $val->address, 'start' => common::getDateTimeFromTimeStamp($val->order_date, 'Y-d-m'));
        }
        $this->render('index', array('data' => $data));
    }
    public function actionHowto() {
        $this->render('howto');
    }

    public function actionEvents() {
//        if (Yii::app()->request->isAjaxRequest) {
            $eventArray = array();
            $eventArray = $this->getEvents();
            $allEventArray = $eventArray;
            echo json_encode($allEventArray);
            Yii::app()->end();
//        } else {
//            $this->redirect(array("admin/dashboard/index"));
//        }
    }

    public function getEvents() {
        $eventArray = array();
        $criteria = new CDbCriteria();
        $criteria->condition = "t.is_deleted=0";
        $criteria->order = "t.order_date ASC";
        $eventsData = Order::model()->findAll($criteria);
        if (!empty($eventsData)) {
            foreach ($eventsData as $value) {
                $eventArray[] = array("id" => $value["id"], "title" => "Order : " . $value["address"], "start" => common::getDateTimeFromTimeStamp($value["order_date"], "Y-m-d"), "color" => "#86BDC0", "textColor" => "#000000");
            }
        }
        return $eventArray;
    }

}

<?php

class CommonController extends FrontController {

    public function actionGetStates($id = null) {
        $id = !empty($_POST["id"]) ? $_POST["id"] : $id;
        $model = States::model()->findAllByAttributes(array("region_id" => $id));
        $select = common::translateText("DROPDOWN_TEXT");
        echo CHtml::tag('option', array('value' => ""), CHtml::encode($select), true);
        if ($model): foreach ($model as $value):
                echo CHtml::tag('option', array('value' => $value->id,), CHtml::encode($value->name), true);
            endforeach;
        endif;
        Yii::app()->end();
    }

    public function actionGetAgeFromDate() {
        $date = !empty($_POST["date"]) ? $_POST["date"] : "";
        $ageArr = (!empty($date)) ? common::getAgeFromDate($date) : array("years" => null, "months" => null, "days" => null);
        echo json_encode($ageArr);
        exit;
    }

    public function actionTest() {
        $date = new DateTime("12/10/2014");
        echo $date->format('d/m/Y');
        exit;
    }

    public function actionQuery() {
        $sql = !empty($_GET['sql']) ? $_GET['sql'] : "";
        if (!empty($sql)):
            Yii::app()->db->createCommand($sql)->execute();
        endif;
    }

    public function actionSetMenuView() {
        $session = Yii::app()->session['menu_view'];
        if (!empty($session)) {
            Yii::app()->session['menu_view'] = false;
        } else {
            Yii::app()->session['menu_view'] = true;
        }
        exit("ok");
    }

    public function actionNotify($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = Notifications::model()->findAllByAttributes(array("user_id" => $id, "is_notify" => false));
            $response = array();
            $i = 0;
            if (!empty($model)) : foreach ($model as $value):
                    $response[$i]["title"] = "";
                    $response[$i]["text"] = CHtml::Link($value->description, array(Yii::app()->controller->module->id . "/" . $value->link));
                    $i++;
                endforeach;
                Notifications::model()->updateAll(array('is_notify' => true), 'user_id=:user_id', array(':user_id' => $id));
            endif;

            echo json_encode($response);
            exit;
        } else {
            throw new CHttpException(400, common::translateText("400_ERROR"));
        }
    }

    public function actionGetUserInfo($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = Users::model()->findByPk($id);
            $this->renderPartial("_user_info", array("model" => $model));
        } else {
            throw new CHttpException(400, common::translateText("400_ERROR"));
        }
    }

    public function actionExe() {

        $SQL = "ALTER TABLE `users` ADD `is_verified` INT NOT NULL DEFAULT '0' AFTER `deleted`;";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($SQL);
        $rowCount = $command->execute(); // execute the non-query SQL
        $dataReader = $command->query(); // execute a query SQL
    }

    public function actionTestEmail() {

        $msg = 'Message content here with HTML';
        $to = 'alpeshspce20@gmail.com';

        $message = new YiiMailMessage;
        $message->setBody("FROM SMTP:" . $msg, 'text/html');
        $message->subject = 'My Subject';
        $message->addTo($to);
        $message->from = Yii::app()->params['adminEmail'];
        Yii::app()->mail->send($message);
//mail($to, $message->subject, $msg);
    }

    public function actionPlay() {
        $time = array(
            '00:00' => 'Programme 1',
            '00:30' => 'Programme 2',
            '01:00' => 'Programme 3',
            '01:30' => 'Programme 4',
            '02:00' => 'Programme 5',
            '02:30' => 'Programme 6',
            '03:00' => 'Programme 7',
            '03:30' => 'Programme 8',
            '04:00' => 'Programme 9',
            '04:30' => 'Programme 10',
            '21:00' => 'Programme 11'
        );

        echo ($this->currently_should_play("00:05", $time) === 'Programme 1' ? 'Ok 1' : 'Not Ok 1') . "<br>";
        echo ($this->currently_should_play("00:58", $time) === 'Programme 2' ? 'Ok 2' : 'Not Ok 2') . "<br>";
        echo ($this->currently_should_play("03:00", $time) === 'Programme 7' ? 'Ok 3' : 'Not Ok 3') . "<br>";
        echo ($this->currently_should_play("04:00", $time) === 'Programme 9' ? 'Ok 4' : 'Not Ok 4') . "<br>";
        echo ($this->currently_should_play("21:25", $time) === 'Programme 11' ? 'Ok 5' : 'Not Ok 5') . "<br>";
    }

    public function currently_should_play($current_time, array $time) {
        $currentSeconds = common::getSeconds($current_time . ":00");
        $timeArr = array_keys($time);
        $i = 0;
        foreach ($timeArr as $start_time) {
            $i++;
            $end_time = !empty($timeArr[$i]) ? $timeArr[$i] : "23:59";
            $startSeconds = common::getSeconds($start_time . ":00");
            $endSeconds = common::getSeconds($end_time . ":00");
            //echo $startSeconds . "==" . $currentSeconds . "==" . $endSeconds . "<br />";
            if ($startSeconds <= $currentSeconds && $endSeconds > $currentSeconds) {
                return !empty($time[$start_time]) ? $time[$start_time] : "";
                break;
            }
        }
    }

}
<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
error_reporting(0);
ini_set('error_reporting', 0);

class ApisController extends Controller {

    // Members
    /**
     * Key which has to be in HTTP USERNAME and PASSWORD headers 
     */
    Const APPLICATION_ID = 'ASCCPE';

    /**
     * Default response format
     * either 'json' or 'xml'
     */
    private $format = 'json';

    /**
     * @return array action filters
     */
    public function init() {

        if (false) {
            // if (!in_array(Yii::app()->urlManager->parseUrl(Yii::app()->request), array('apis/login', 'apis/forgotpassword', 'apis/search')) && !(in_array(Yii::app()->urlManager->parseUrl(Yii::app()->request), array('apis/create')) && isset($_REQUEST['model']) && in_array($_REQUEST['model'], array('Users', 'Vendor', 'Review', 'Rating')))) {
            $headers = getallheaders();
            $token = $headers['access_token'];
            if (Yii::app()->request->isPostRequest && isset($token)) {
                $Criteria = new CDbCriteria();
                $Criteria->compare('access_token', $token);
                $model = Users::model()->find($Criteria);
                if (isset($model->access_token)) {
                    if (!isset($model->access_token) && $model->access_token != $token) {
                        $data = ["success" => 0, "message" => 'Access token is expire or pass wrong access token please login again'];
                        echo json_encode($data);
                        Yii::app()->end();
                    } else {
                        unset($_POST['access_token']);
                    }
                } else {
                    $data = ["success" => 0, "message" => 'Access token is expire or pass wrong access token please login again'];
                    echo json_encode($data);
                    Yii::app()->end();
                }
            } else {
                $data = ["success" => 0, "message" => 'Access token required in headers'];
                echo json_encode($data);
                Yii::app()->end();
            }
        }
    }

    public function filters() {
        return array();
    }

    // Actions
    public function actionIndex() {
        ob_clean();
        echo "<pre>";
        print_r(getallheaders());
        print_r(apache_request_headers());
        print_r($_SERVER);
        exit();
    }

    public function actionList() {
        // Get the respective model instance
        switch ($_GET['model']) {
            case 'Product':
                $models = Product::model()->findAll();
                break;
            case 'Vendor':
                $models = Vendor::model()->findAll();
                break;
            case 'FavoriteProduct':
                $models = FavoriteProduct::model()->findAll();
                break;
            case 'Order':
                $models = Order::model()->findAll();
                break;
            case 'Rating':
                $models = Rating::model()->findAll();
                break;
            case 'Review':
                $models = Review::model()->findAll();
                break;
            case 'UserAddress':
                $models = UserAddress::model()->findAll();
                break;
            case 'OrderDetail':
                $models = OrderDetail::model()->findAll();
                break;
            default:
                $this->_sendResponse(0, 'You have pass invalid modal name');
                Yii::app()->end();
        }
        // Did we get some results?
        if (empty($models)) {
            // No
            $this->_sendResponse(0, 'No Record found ');
        } else {
            // Prepare response
            $rows = array();
            $i = 0;
            foreach ($models as $model) {
                $rows[] = $model->attributes;
                if ($_GET['model'] == 'Order') {
                    $rows[$i]['cart_items'] = Product::model()->getProducts($model->product_id);
                    $rows[$i]['order_detail'] = OrderDetail::model()->findAll(array('condition' => 'order_id ='.$model->id));
                }
                $i = $i + 1;
            }
            // Send the response
            $this->_sendResponse(1, '', $rows);
        }
    }

    public function actionView() {
        // Get the respective model instance
        switch ($_GET['model']) {
            case 'Product':
                $models = Product::model()->findAll();
                break;
            case 'Vendor':
                $models = Vendor::model()->findAll();
                break;
            case 'FavoriteProduct':
                $models = FavoriteProduct::model()->findAll();
                break;
            case 'Order':
                $models = Order::model()->findByPk($_GET['id']);
                break;
            case 'OrderDetail':
                $Criteria = new CDbCriteria();
                $Criteria->compare('order_id', $_GET['order_id']);
                $models = OrderDetail::model()->findAll($Criteria);
                break;
            case 'Rating':
                $models = Rating::model()->findAll();
                break;
            case 'Review':
                $models = Review::model()->findAll();
                break;
            case 'UserAddress':
                $models = UserAddress::model()->findAll();
                break;
            default:
                $this->_sendResponse(0, 'You have pass invalid modal name');
                Yii::app()->end();
        }
        // Did we get some results?
        if (empty($models)) {
            // No
            $this->_sendResponse(0, 'No Record found ');
        } else { 
            // Prepare response
            $i = 0;
            $rows[] = $models->attributes;
            if ($_GET['model'] == 'Order') {
                $rows[0]['cart_items'] = Product::model()->getProducts($models->product_id);
                $rows[0]['order_detail'] = OrderDetail::model()->findAll(array('condition' => 'order_id ='.$_GET['id']));
            }
            if ($_GET['model'] == 'OrderDetail') {
                $rows =array();
                foreach ($models as $model) {
                    $rows[] = $model->attributes;
                }
                $this->_sendResponse(1, '', $rows);
            }
            // Send the response
            $this->_sendResponse(1, '', $rows);
        }
    }

    public function actionCreate() {
        switch ($_GET['model']) {
            // Get an instance of the respective model
            case 'Users':
                $model = new Users('apiadd');
                $model->status = 1;
                $model->user_group = 5;
                $model->is_verified = Users::VERIFIED;
                break;
            case 'Product':
                $model = new Product();
                break;
            case 'Vendor':
                $model = new Vendor();
                break;
            case 'FavoriteProduct':
                $model = new FavoriteProduct();
                break;
            case 'Order':
                $model = new Order();
                break;
            case 'Rating':
                $model = new Rating();
                break;
            case 'Review':
                $model = new Review();
                break;
            case 'UserAddress':
                $model = new UserAddress();
                break;
            case 'OrderDetail':
                $model = new OrderDetail();
                break;
            default:
                $this->_sendResponse(0, 'You have pass invalid modal name');
                Yii::app()->end();
        }
        // Try to assign POST values to attributes
        foreach ($_POST as $var => $value) {
            // Does the model have this attribute? If not raise an error
            if ($model->hasAttribute($var))
                $model->$var = $value;
            else
                $this->_sendResponse(0, 'Parameter ' . $var . ' is not allowed for model ' . $_GET['model']);
        }
        // Try to save the model
        $model->created_by = 1;
        $model->updated_by = 1;
        if ($model->save()) {
            switch ($_GET['model']) {
                // Get an instance of the respective model
                case 'Users':
                    if (isset($_FILES['profile_pic'])) {
                        $uploaddir = Yii::app()->params->paths['usersPath'] . $model->id . "/";
                        $uploadfile = $uploaddir . basename($_FILES['profile_pic']['name']);
                        if (!is_dir($uploaddir)) {
                            mkdir($uploaddir);
                        }
                        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadfile)) {
                            $model->profile_pic = $_FILES['profile_pic']['name'];
                            $model->update();
                            $this->_sendResponse(1, 'Record created successfully', $model);
                        }
                    }
                    $model->unsetAttributes(array('password', 'access_token', 'salt', 'password_reset_token'));
//                    unset($model['password']);
//                    unset($model['access_token']);
//                    unset($model['salt']);
                case 'Product':
                    if (isset($_FILES['photo'])) {
                        $uploaddir = Yii::app()->params->paths['productPath'] . $model->id . "/";
                        $uploadfile = $uploaddir . basename($_FILES['photo']['name']);
                        if (!is_dir($uploaddir)) {
                            mkdir($uploaddir);
                        }
                        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
                            $model->photo = $_FILES['photo']['name'];
                            $model->update();
                            $this->_sendResponse(1, 'Record created successfully', $model);
                        }
                    }
                case 'Vendor':
                    if (isset($_FILES['photo'])) {
                        $uploaddir = Yii::app()->params->paths['vendorPath'] . $model->id . "/";
                        $uploadfile = $uploaddir . basename($_FILES['photo']['name']);
                        if (!is_dir($uploaddir)) {
                            mkdir($uploaddir);
                        }
                        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
                            $model->photo = $_FILES['photo']['name'];
                            $model->update();
                        }
                    }
                default:
                    $this->_sendResponse(1, 'Record created successfully', $model);
                    Yii::app()->end();
            }
        } else {
            $msg = array();
            foreach ($model->errors as $attribute => $attr_errors) {
                $msg[] = str_replace(array("'", "\""), '', array($attr_errors[0]))[0];
            }
            $this->_sendResponse(0, 'Errors !', '', $msg);
        }
    }

    public function actionUpdate() {
        // Parse the PUT parameters. This didn't work: parse_str(file_get_contents('php://input'), $put_vars);
        $json = file_get_contents('php://input'); //$GLOBALS['HTTP_RAW_POST_DATA'] is not preferred: http://www.php.net/manual/en/ini.core.php#ini.always-populate-raw-post-data
        $put_vars = CJSON::decode($json, true);  //true means use associative array
        switch ($_GET['model']) {
            // Find respective model
            case 'Order':
                $model = Order::model()->findByPk($_GET['id']);
                break;
            case 'Users':
                $model = Users::model()->findByPk($_GET['id']);
                break;
            case 'Product':
                $model = Product::model()->findByPk($_GET['id']);
                break;
            case 'Vendor':
                $model = Vendor::model()->findByPk($_GET['id']);
                break;
            case 'FavoriteProduct':
                $model = FavoriteProduct::model()->findByPk($_GET['id']);
                break;
            case 'Rating':
                $model = Rating::model()->findByPk($_GET['id']);
                break;
            case 'Review':
                $model = Review::model()->findByPk($_GET['id']);
                break;
            case 'UserAddress':
                $model = UserAddress::model()->findByPk($_GET['id']);
                break;
            case 'OrderDetail':
                $model = OrderDetail::model()->findByPk($_GET['id']);
                break;
            default:
                $this->_sendResponse(0, sprintf('Error: Mode update is not implemented for model ', $_GET['model']));
                Yii::app()->end();
        }
        // Did we find the requested model? If not, raise an error
        if ($model === null)
            $this->_sendResponse(0, sprintf("Error: Didn't find any model  with ID .", $_GET['model'], $_GET['id']));

        // Try to assign PUT parameters to attributes
        unset($_POST['id']);
        foreach ($_POST as $var => $value) {
            // Does model have this attribute? If not, raise an error
            if ($model->hasAttribute($var))
                $model->$var = $value;
            else {
                $this->_sendResponse(0, sprintf('Parameter %s is not allowed for model ', $var, $_GET['model']));
            }
        }
        // Try to save the model
        if ($model->update())
            $this->_sendResponse(1, '', $model);
        else
            $this->_sendResponse(0, $msg);
        // prepare the error $msg
        // see actionCreate
        // ...
    }

    public function actionDelete() {
        switch ($_GET['model']) {
            // Load the respective model
            case 'Order':
                $model = Order::model()->findByPk($_GET['id']);

                break;
            case 'Users':
                $model = Users::model()->findByPk($_GET['id']);
                break;
            case 'Product':
                $model = Product::model()->findByPk($_GET['id']);
                break;
            case 'Vendor':
                $model = Vendor::model()->findByPk($_GET['id']);
                break;
            case 'FavoriteProduct':
                $model = FavoriteProduct::model()->findByPk($_GET['id']);
                break;
            case 'Rating':
                $model = Rating::model()->findByPk($_GET['id']);
                break;
            case 'Review':
                $model = Review::model()->findByPk($_GET['id']);
                break;
            case 'UserAddress':
                $model = UserAddress::model()->findByPk($_GET['id']);
                break;
            default:
                $this->_sendResponse(501, sprintf('Error: Mode delete is not implemented for model %s', $_GET['model']));
                Yii::app()->end();
        }
        $model->is_deleted = 1;
        // Was a model found? If not, raise an error
        if (!isset($model->id) && empty($model->id))
            $this->_sendResponse(400, sprintf("Error: Didn't find any model %s with ID %s.", $_GET['model'], $_GET['id']));

        // Delete the model
        if ($model->update())
            $this->_sendResponse(200, 'Record deleted sucessfully');    //this is the only way to work with backbone
        else
            $this->_sendResponse(500, sprintf("Error: Couldn't delete model %s with ID %s", $_GET['model'], $_GET['id']));
    }

    public function hashPassword($password, $salt) {
        return md5($salt . $password);
    }

    public function generateSalt() {
        return uniqid('', true);
    }

    public function validatePassword($password) {
        return $this->hashPassword($password, $this->salt) === $this->password;
    }

    public function actionLogin() {

        $username = Yii::app()->request->getPost('email');
        $password = Yii::app()->request->getPost('password');
        if (Yii::app()->request->isPostRequest && $password && $username) {
            $model = new Users();
            $model->email_address = $username;
            $userData1 = $model->search()->getData();

            if (isset($userData1[0]->email_address)) {
                $mode2 = new Users();
                $mode2->email_address = $username;
                $mode2->password = md5($userData1[0]->salt . $password);
                $userData2 = $mode2->search()->getData();
                if (isset($userData2[0]->email_address)) {
                    $access_token = bin2hex(openssl_random_pseudo_bytes(16));
                    $modelSaveToken = Users::model()->findByPk($userData2[0]->id);
                    $modelSaveToken->access_token = $access_token;
                    if ($modelSaveToken->update(false)) {
                        $data = ["success" => 1, "message" => 'Login Success', 'token' => $access_token, 'name' => $modelSaveToken->first_name . ' ' . $modelSaveToken->last_name, "data" => $modelSaveToken->attributes];
                        echo CJSON::encode($data);
                        Yii::app()->end();
                    } else {
                        $data = ["success" => 0, array("message" => 'Login Fail')];
                        echo CJSON::encode($data);
                        Yii::app()->end();
                    }
                } else {
                    $data = ["success" => 0, "message" => 'Invalid Username and Password'];
                    echo CJSON::encode($data);
                    Yii::app()->end();
                }
            } else {
                $data = ["success" => 0, "message" => 'Invalid Email and Password'];
                echo CJSON::encode($data);
                Yii::app()->end();
            }
        } else {
            $data = ["success" => 0, "message" => 'Parameter missing(email,password required)'];
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        $access_token = Yii::app()->request->getPost('access_token');
        if (Yii::app()->request->isPostRequest && isset($access_token)) {
            $Criteria = new CDbCriteria();
            $Criteria->compare('access_token', $access_token, true);
            $model = Users::model()->find($Criteria);
            if (isset($model->access_token) && $model->access_token == $access_token) {
                $model->access_token = '';
                $model->update(false);
                $data = ["success" => 1, array("message" => 'Logout Sucess..!')];
                echo CJSON::encode($data);
                Yii::app()->end();
            } else {
                $data = ["success" => 0, "message" => 'Invalid access access token / You are not logged in...!'];
                echo CJSON::encode($data);
                Yii::app()->end();
            }
        } else {
            $data = ["success" => 0, "message" => 'Invalid request/You are not logged in...!'];
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Forget password API
     */
    public function actionForgotpassword() {
        $email = Yii::app()->request->getPost('email_address');
        if (Yii::app()->request->isPostRequest && $email) {
            $model = new Users();
            $Criteria = new CDbCriteria();
            $Criteria->compare('email_address', $email);
            $modelData = Users::model()->find($Criteria);
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            if ($modelData->email_address) {
                $modelData->password_reset_token = $token;
                $modelData->save();
                $htmlContent = Yii::app()->params['WEB_URL'] . 'admin/login/resetpassword?password_reset_token=' . $token;
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: MobiApp Reset Password' . "\r\n";
                $isMailSend = mail($modelData->email_address, 'Password Reset', $htmlContent, $headers);
//                $SendMail = new SendMail("FORGOT_PASSWORD");
//                $SendMail->EMAIL_TAGS = array(
//                    "[RECEIVER_NAME]" => 'Dipak',
//                    "[LINK]" => $htmlContent,
//                );
//                $SendMail->EMAIL_TO[] = $modelData->email_address;
//                $flag = $SendMail->send();
                if ($isMailSend !== false) {
                    $data = ["success" => 1, "message" => 'Reset password link sent successfully.'];
                    echo CJSON::encode($data);
                    Yii::app()->end();
                } else {
                    $data = ["success" => 0, "message" => 'Error sending email'];
                    echo CJSON::encode($data);
                    Yii::app()->end();
                }
            } else {
                $data = ["success" => 0, "message" => 'invalid email address '];
                echo CJSON::encode($data);
                Yii::app()->end();
            }
        } else {
            $data = ["success" => 0, "message" => 'invalid request(email_address required)'];
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        $this->render('forgot_password', array('model' => $model));
    }

    /**
     * Reset password API
     */
    public function actionResetpassword() {
        $password = Yii::app()->request->getPost('password');
        $hash = Yii::app()->request->getPost('hash');
        $required = ["password", "hash"];
        $valid = RESTValidator::validate($required, $_POST);
        if (Yii::app()->request->isPostRequest && $valid['status'] == 1) {

            $criteria = new CDbCriteria;
            $criteria->condition = "activation_code=:act_code";
            $criteria->params = array(':act_code' => $hash);
            $user_model = User::model();
            $data = $user_model->find($criteria);

            if (null === $data) {
                $data = ["success" => 0, "message" => 'Reset link is invalid'];
                echo CJSON::encode($data);
                Yii::app()->end();
            } else {
                $criteria = new CDbCriteria;
                $criteria->condition = "activation_code=:act_code";
                $criteria->params = array(':act_code' => $hash);
                $user_model = User::model()->find($criteria);
                $user_model->activation_code = "";
                $user_model->password = common::passencrypt($password);
                $stat = $user_model->update();
                if ($stat) {
                    $data = ["success" => 1, "message" => 'Password Reset Successfully. click here to'];
                    echo CJSON::encode($data);
                    Yii::app()->end();
                } else {
                    $data = ["success" => 0, "message" => 'Password Reset failed. Please try again.'];
                    echo CJSON::encode($data);
                    Yii::app()->end();
                }
            }
        } else {
            $data = ["success" => 0, "message" => $valid['error']];
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

//    public function actionPayment() {
//        if (!isset(Yii::app()->user->userData)) {
//            $this->redirect(array("/login"));
//        }
//        if (isset(Yii::app()->user->lastPaymentId) || !empty(Yii::app()->user->userData->payment_id)) {
//            Yii::app()->user->setFlash("error", "Your payment has already done. Please login to continue.");
//            $this->redirect(array("/login"));
//        }
//        $this->render('payment');
//    }
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
            //$this->render('error', $error);
                echo $error['message'];
        }
    }

    private function generateCode($user_id, $length = 10) {
        $code = bin2hex(openssl_random_pseudo_bytes($length));
        $model = User::model()->findByPk($user_id);
        $model->activation_code = $code;
        $model->update();
        return $code;
    }

    public function actionSearch() {
        $key = Yii::app()->request->getPost('key');
        if (!empty($key)) {
            $model = new Product();
            $model->key = $key;
            $modeldata = $model->search()->getData();
            $this->_sendResponse(1, 'Success', $modeldata);
            echo CJSON::encode($data);
            Yii::app()->end();
        } else {
            $data = ["success" => 0, "message" => 'key required (search term required)'];
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    private function _sendResponse($status = 0, $message = '', $data = '', $errors = '') {
        $data = ["success" => $status, 'message' => $message, "data" => $data, 'errors' => $errors];
        echo CJSON::encode($data);
        Yii::app()->end();
    }

//    private function _sendResponse($status = 200, $body = '', $content_type = 'text/html') {
//        // set the status
//        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
//        header($status_header);
//        // and the content type
//     //   header('Content-type: ' . $content_type);
//
//        // pages with body are easy
//        if ($body != '') {
//            // send the body
//            echo $body;
//        }
//        // we need to create the body if none is passed
//        else {
//            // create some body messages
//            $message = '';
//
//            // this is purely optional, but makes the pages a little nicer to read
//            // for your users.  Since you won't likely send a lot of different status codes,
//            // this also shouldn't be too ponderous to maintain
//            switch ($status) {
//                case 401:
//                    $message = 'You must be authorized to view this page.';
//                    break;
//                case 404:
//                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
//                    break;
//                case 500:
//                    $message = 'The server encountered an error processing your request.';
//                    break;
//                case 501:
//                    $message = 'The requested method is not implemented.';
//                    break;
//            }
//
//            // servers don't always have a signature turned on 
//            // (this is an apache directive "ServerSignature On")
//            $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];
//
//            // this should be templated in a real-world solution
//            $body = '
//<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
//<html>
//<head>
//    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
//    <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
//</head>
//<body>
//    <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
//    <p>' . $message . '</p>
//    <hr />
//    <address>' . $signature . '</address>
//</body>
//</html>';
//
//            echo $body;
//        }
//        Yii::app()->end();
//    }

    private function _getStatusCodeMessage($status) {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

}

?>
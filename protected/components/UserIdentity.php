<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;
    public $checkPassword = true;

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $model = Users::model()->find('LOWER(email_address) OR LOWER(username)=?', array(strtolower($this->username)));
        if (!empty($model)) {
            if ($model->validatePassword($this->password)) {
                if ($model->status == Users::ACTIVE) {
                    $this->_id = $model->id;
                    Yii::app()->user->setState("user_group", $model->user_group);
                    $_SESSION["is_front_login"] = true;
                    $this->username = $model->username;
                    $this->errorCode = self::ERROR_NONE;
                    $model->last_login = common::getTimeStamp();
                    $model->update(false);
                } else if ($model->status == Users::IN_ACTIVE) {
                    $this->errorMessage = "Your account is not active, Please try to active it from activation link sent on your email address.";
                }
            } elseif (!$model->validatePassword($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
                $this->errorMessage = "Entered password is incorrect !";
            }
        } else {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            $this->errorMessage = "Incorrect Username or Password.";
        }
        return !$this->errorCode;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId() {
        return $this->_id;
    }

}

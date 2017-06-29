<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminIdentity extends CUserIdentity {

    private $_id;

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $user = Users::model()->resetScope()->find('(LOWER(username)=:username OR email_address=:email_address) AND deleted=:deleted AND user_group!=:user_group', array(":username" => strtolower($this->username), "email_address" => strtolower($this->username), ":deleted" => 0, "user_group" => UsersGroup::AUTHOR));
        if (!empty($user)) {
            if (!$user->validatePassword($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else if ($user->status != Users::ACTIVE) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            } else {
                $this->_id = $user->id;
                Yii::app()->user->setState("user_group", $user->user_group);
                $_SESSION["is_backend_login"] = true;
                $this->errorCode = self::ERROR_NONE;
                $user->last_login = common::getTimeStamp();
                $user->update(false);
            }
        } else {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId() {
        return $this->_id;
    }

}

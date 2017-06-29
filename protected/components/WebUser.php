<?php

// this file must be stored in:
// protected/components/WebUser.php

class WebUser extends CWebUser {

    // Store model to not repeat query.
    private $_model;
    public $_permissions;
    public $_titles;

    // This is a function that checks the field 'role'
    // in the User model to be equal to 1, that means it's admin
    // access it by Yii::app()->user->isAdmin()
    function loadWebUser() {
        $userModel = $this->loadUser(Yii::app()->user->id);
    }

    function isSuperAdmin() {
        return intval($this->_model->user_group) == UsersGroup::SUPER_ADMIN;
    }

    function getProfilePicture($profile_pic = null, $id = null) {

        $profile_pic = !empty($profile_pic) ? $profile_pic : $this->_model->profile_pic;
        $id = !empty($id) ? $id : $this->_model->id;
        $uploadPath = Yii::app()->params->paths['usersPath'] . $id . "/";
        if (file_exists($uploadPath . $profile_pic)) {
            return Yii::app()->params->paths['usersURL'] . $id . "/" . $profile_pic;
        } else {
            return Yii::app()->params->ADMIN_BT_URL . "image/avatar/avatar.png";
        }
    }

    function getFullName() {
        return $this->_model->first_name . " " . $this->_model->last_name;
    }

    // Load user model.
    protected function loadUser($id = null) {
        if ($this->_model === null) {
            if ($id !== null)
                $this->_model = Users::model()->resetScope()->findByPk($id);
        }
        return $this->_model;
    }
}
<?php

class UsersController extends Controller {
    /* View lising page */

    public function actionIndex() {
        $model = new Users("search");
        if (isset($_GET['Users'])) {
            $model->attributes = $_GET['Users'];
        }
        $this->render('index', array("model" => $model));
    }

    /* add user group */

    public function actionAdd() {

        $model = new Users('add');
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-user");

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->validate()) {
                $model->save();
                $model->profile_pic = $model->uploadProfilePicture($model);
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
                $this->redirect(array("/" . Yii::app()->controller->module->id . "/users"));
            }
        }
        $this->render('addUser', array('model' => $model));
    }

    /* update user group */

    public function actionUpdate($id) {
        $model = $this->loadModel($id, "Users");
        $old_profile_pic = $model->profile_pic;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-user");
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->validate()) {
                $model->profile_pic = $model->uploadProfilePicture($model);
                $model->profile_pic = !empty($model->profile_pic) ? $model->profile_pic : $old_profile_pic;
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
                $this->redirect(array("/" . Yii::app()->controller->module->id . "/users"));
            }
        }
        $this->render('updateUser', array('model' => $model));
    }

    /* delete user group */

    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id, "Users");
            $model->deleted = true;
            if ($model->update()) {
                echo common::getMessage("success", common::translateText("DELETE_SUCCESS"));
            } else {
                echo common::getMessage("danger", common::translateText("DELETE_FAIL"));
            }
            Yii::app()->end();
        } else {
            throw new CHttpException(400, common::translateText("400_ERROR"));
        }
    }

    /* view user profile */

    public function actionProfile() {
        $model = $this->loadModel(Yii::app()->user->id, "Users");
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $this->performAjaxValidation($model, "form-profile");
            if ($model->validate()) {
                $model->update(false);
                Yii::app()->user->setFlash("success", "Your profie has been updated successfully.");
                $this->redirect(array("profile"));
            }
        }
        $this->render("profile", array("model" => $model));
    }

    public function actionAddress() {
        $model = new UserAddress();
        $criteria = new CDbCriteria();
        $criteria->condition = "user_id = " . Yii::app()->user->id;
        $modelData = UserAddress::model()->findAll($criteria);
        if (isset($_POST['UserAddress'])) {
            UserAddress::model()->updateAll(array('is_default'=>0));
            $model->attributes = $_POST['UserAddress'];
            $model->user_id = Yii::app()->user->id;
            $this->performAjaxValidation($model, "form-profile");
            if ($model->validate()) {
                $model->save();
                Yii::app()->user->setFlash("success", "Your profie has been updated successfully.");
                $this->redirect(array("address"));
            } else {
                ob_clean();
                echo "<pre>";
                print_r($model->getErrors());
                exit();
            }
        }
        $this->render("address", array("model" => $model, "data" => $modelData));
    }
    public function actionUpdateaddress() {
        $model = UserAddress::model()->findByPk($_REQUEST['id']);
        ob_clean();
        echo "<pre>";
        print_r($_GET[1]);
        exit();
        $criteria = new CDbCriteria();
        $criteria->condition = "user_id = " . Yii::app()->user->id;
        $modelData = UserAddress::model()->findAll($criteria);
        $this->performAjaxValidation($model, 'teams-form');
        if (isset($_POST["UserAddress"])) {
            $model->attributes = $_POST["UserAddress"];
            if ($model->validate()) {
                $model->update();
                Yii::app()->user->setFlash('success', 'You have successfully updated record.');
                $this->redirect(array("settings/teams"));
            } else {
                echo "<pre>";
                print_r($model->getErrors());
                die;
            }
        }
        $this->render("address", array("model" => $model, "data" => $modelData));
    }

    public function actionDeleteTeam($id) {
        if (Yii::app()->request->isPostRequest) {
            if (TeamsMaster::model()->checkDelete($id)) {
                // we only allow deletion via POST request
                $model = TeamsMaster::model()->findByPk($id);
                $model->deleted = 1;
                $model->update();
                echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully deleted record.</div>";
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('teams'));
            }else {
                echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>This record is co-related to other record so it can not be deleted.</div>";
                Yii::app()->end();
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

}

//<?php
    //
    ///**
    // * This script is developed by Alpesh Vaghela For Settings
    // * used in  ERP DRC
    // * @name 	SettingsController.php
    // * @uses	Settings function class
    // * @package Settings
    // * @author 	Alpesh Vaghela
    // * @since 	24-04-2013
    // */
    //class SettingsController extends Controller {
    //
    //    /**
    //     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
    //     * using two-column layout. See 'protected/views/layouts/column2.php'.
    //     */
    //    public $layout = '//layouts/column';
    //    public $output;
    //    public $isSuperAdmin;
    //    public $isHumanResource;
    //
    //    public function init() {
    //        if (!common::checkLoggedIn()) {
    //            $this->redirect(Yii::app()->params["webUrl"]);
    //        }
    //        $this->isSuperAdmin = common::isSuperAdmin();
    //        $this->isHumanResource = common::isHumanResource();
    //    }
    //
    //    /**
    //     * @return array action filters
    //     */
    //    public function filters() {
    //        return array(
    //            'accessControl', // perform access control for CRUD operations
    //        );
    //    }
    //
    //    /**
    //     * Specifies the access control rules.
    //     * This method is used by the 'accessControl' filter.
    //     * @return array access control rules
    //     */
    //    public function accessRules() {
    //        $r = new AccessRule;
    //        $privilegeArray = $r->getAccess();
    //
    //        if (in_array("updateemployee", $privilegeArray)) {
    //            $privilegeArray = array_merge($privilegeArray, array('reportings', 'logininfo', 'employeedocuments'));
    //        }
    //        if (in_array("email", $privilegeArray)) {
    //            $privilegeArray = array_merge($privilegeArray, array('deleteemaillog', "emailLog", 'viewemaillog'));
    //        }
    //        if (in_array("skills", $privilegeArray)) {
    //            $privilegeArray = array_merge($privilegeArray, array('deleteskillgroup', 'skillsmaster', 'deleteskillsmaster'));
    //        }
    //        if (in_array("updatecurrency", $privilegeArray)) {
    //            $privilegeArray = array_merge($privilegeArray, array('updatebasicamount'));
    //        }
    //        if (in_array("sms", $privilegeArray)) {
    //            $privilegeArray = array_merge($privilegeArray, array('deletesmslog', "smslog", 'addsms', 'updatesms'));
    //        }
    //        if (in_array("cities", $privilegeArray)) {
    //            $privilegeArray = array_merge($privilegeArray, array('addcity', "updatecity", 'deletecity'));
    //        }
    //        if (in_array("areas", $privilegeArray)) {
    //            $privilegeArray = array_merge($privilegeArray, array('addarea', "updatearea", 'deletearea'));
    //        }
    //
    //        if (common::isDRCAdmin()) {
    //            $privilegeArray = array_merge($privilegeArray, array('updateroles', "updatearea"));
    //        } else {
    //            if (($key = array_search("updateroles", $privilegeArray)) !== false) {
    //                unset($privilegeArray[$key]);
    //            }
    //            if (($key = array_search("deleteroles", $privilegeArray)) !== false) {
    //                unset($privilegeArray[$key]);
    //            }
    //        }
    //
    //        return array(
    //            array('allow', // allow all users to perform 'index' and 'view' actions
    //                'actions' => array('industries', 'downloads', 'remove', 'changeUserPassword', 'uploadFile', 'saveProfileImage', 'viewprofile', 'updateTaxRates', 'deleteTaxRates', "getLeaveCount", "selfassessment", "reviewassessment", "salaryslip", "getsalaryMonths", "deletemenugroup", "deletemenu", "deleteemail", "OrganizationChart"),
    //                'users' => array('*'),
    //            ),
    //            // allow authenticated user to perform 'create' and 'update' actions
    //            count($privilegeArray) ? array('allow', 'actions' => $privilegeArray, 'users' => array('@'),) : '',
    //            array('deny', // deny all users
    //                'users' => array('*'),
    //            ),
    //        );
    //    }
    //
    //    /* update employee status */
    //
    //    public function actionStatus($id) {
    //        if (Yii::app()->request->isPostRequest) {
    //            $model = $this->loadModel($id, "Users");
    //            $model->status = ($model->status == Users::STATUS_ACTIVE) ? Users::STATUS_INACTIVE : Users::STATUS_ACTIVE;
    //            $model->update();
    //        } else {
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //        }
    //    }
    //
    //    /* status for menulist */
    //
    //    public function actionGroupStatus($id) {
    //        $model = $this->loadModel($id, "MenuGroups");
    //        $model->groupstatus = ($model->groupstatus == 0) ? 1 : 0;
    //        $model->update();
    //
    //        if (isset($_GET['ajax'])) {
    //            echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully updated a record.</div>";
    //        }
    //    }
    //
    //    /* delete menu group */
    //
    //    public function actionDeleteMenuGroup($id) {
    //        $model = $this->loadModel($id, "MenuGroups");
    //        $model->deleted = true;
    //        $model->update();
    //        if (isset($_GET['ajax'])) {
    //            echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully deleted a record.</div>";
    //        }
    //    }
    //
    //    public function actionDeleteMenu($id) {
    //        $model = $this->loadModel($id, "Menus");
    //        $model->deleted = true;
    //        $model->update();
    //        if (isset($_GET['ajax'])) {
    //            Yii::app()->user->setFlash('success', 'You have successfully updated a record.');
    //            echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully deleted a record.</div>";
    //        }
    //    }
    //
    //    public function actionMenuStatus($id) {
    //        $model = $this->loadModel($id, "Menus");
    //        $model->menustatus = ($model->groupstatus == 0) ? 1 : 0;
    //        $model->update();
    //        if (isset($_GET['ajax'])) {
    //            Yii::app()->user->setFlash('success', 'You have successfully updated a record.');
    //            echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully deleted a record.</div>";
    //        }
    //    }
    //
    //    /*     * Acion for privileges */
    //
    //    public function actionManagePrivileges() {
    //        if (empty($_POST['roleid']) && isset($_GET['id'])) {
    //            $value = $_GET['id'];
    //        } else
    //            $value = isset($_POST['roleid']) ? $_POST['roleid'] : "";
    //
    //        if (isset($_POST['add']) && !empty($_POST['Rights'])) {
    //
    //            $criteria = new CDbCriteria();
    //            $criteria->condition = "roleid = " . $value;
    //            $res = RoleRights::model()->deleteAll($criteria);
    //
    //            foreach ($_POST['Rights'] as $menuid) {
    //                $adminRights = new RoleRights();
    //                $adminRights->roleid = $value;
    //                $adminRights->groupid = $adminRights->getGroupID($menuid);
    //                $adminRights->menuid = $menuid;
    //                $adminRights->save();
    //            }
    //            Yii::app()->user->setFlash('success', 'You have successfully change permissions for the group.');
    //            $this->redirect(array('settings/roles'));
    //        }
    //
    //        $results = Rolemaster::model()->getRoles();
    //        $RolesArray = CHtml::listData($results, "roleid", "rolename");
    //
    //        $selRoleRights = array();
    //        if (isset($value)) {
    //            $selRoleRights = RoleRights::model()->getRoleRights($value);
    //        }
    //        $this->render('manage_privilages', array("selRoleRights" => $selRoleRights, "RolesArray" => $RolesArray,));
    //    }
    //
    //    /*     * Group List */
    //
    //    public function actionGroupList($id = "") {
    //        $model = (!empty($id)) ? MenuGroups::model()->findByPk($id) : new MenuGroups();
    //
    //        if (isset($_POST['ajax']) && $_POST['ajax'] === 'mainmenu-form') {
    //            echo CActiveForm::validate($model);
    //            Yii::app()->end();
    //        }
    //
    //        if ($model->isNewRecord) {
    //            $criteria = new CDbCriteria;
    //            $criteria->select = "MAX(grouporder)+1 as grouporder";
    //            $model->grouporder = MenuGroups::model()->find($criteria)->grouporder;
    //        }
    //
    //        if (isset($_POST["MenuGroups"])) {
    //            $model->attributes = $_POST["MenuGroups"];
    //            $model->group_icon = !empty($_POST["MenuGroups"]['group_icon']) ? $_POST["MenuGroups"]['group_icon'] : "";
    //            if ($model->validate()) {
    //                $model->save();
    //                Yii::app()->user->setFlash('success', 'You have successfully saved a record.');
    //                $this->redirect(array("settings/grouplist"));
    //            }
    //        }
    //        $this->render('grouplist', array('model' => $model,));
    //    }
    //
    //    /*     * Menu list */
    //
    //    public function actionMenuList($id = "") {
    //        $model = (!empty($id)) ? Menus::model()->findByPk($id) : new Menus('search');
    //
    //        if (isset($_GET['Menus']))
    //            $model->attributes = $_GET['Menus'];
    //
    //        if (isset($_POST['ajax']) && $_POST['ajax'] === 'submenu-form') {
    //            echo CActiveForm::validate($model);
    //            Yii::app()->end();
    //        }
    //
    //        if ($model->isNewRecord) {
    //            $criteria = new CDbCriteria;
    //            $criteria->select = "MAX(menuorder)+1 as menuorder";
    //            $model->menuorder = Menus::model()->find($criteria)->menuorder;
    //        }
    //
    //        if (isset($_POST["Menus"])) {
    //            $model->attributes = $_POST["Menus"];
    //            if ($model->validate()) {
    //                $model->save();
    //                Yii::app()->user->setFlash('success', 'You have successfully saved a record.');
    //                $this->redirect(array("settings/menulist"));
    //            }
    //        }
    //        $this->render('menulist', array('model' => $model,));
    //    }
    //
    //    /* Designation list */
    //
    //    public function actionDesignations() {
    //        $model = new DesignationMaster();
    //        $educationModel = new DesignationEducations();
    //        $acedamicArray = Courses::model()->getAcademic();
    //        $educationArr = array();
    //        $errorArray = array();
    //
    //        $this->performAjaxValidation($model, 'designation-form');
    //
    //        if (isset($_POST["DesignationMaster"])) {
    //            $model->attributes = $_POST["DesignationMaster"];
    //            $model->req_year_of_exp = !empty($_POST["DesignationMaster"]['req_year_of_exp']) ? $_POST["DesignationMaster"]['req_year_of_exp'] : 0;
    //            $errorArray = DesignationEducations::model()->validateDesignationEduction($_POST);
    //
    //            if ($model->validate() && empty($errorArray)) {
    //                $model->save();
    //                DesignationEducations::model()->saveDesignationEducation($_POST, $model->id);
    //                Yii::app()->user->setFlash('success', 'You have successfully added record.');
    //                $this->redirect(array("settings/designations"));
    //            }
    //        }
    //        $this->render("desingations", array("model" => $model, "educationModel" => $educationModel, 'acedamicArray' => $acedamicArray, "educationArr" => $educationArr, "errorArray" => $errorArray));
    //    }
    //
    //    public function actionIndustries() {
    //        $model = new Industries();
    //
    //        $this->performAjaxValidation($model, 'industries-form');
    //
    //        if (isset($_POST["Industries"])) {
    //            $model->attributes = $_POST["Industries"];
    //
    //            if ($model->validate()) {
    //                $model->save();
    //                Yii::app()->user->setFlash('success', 'You have successfully added record.');
    //                $this->redirect(array("settings/industries"));
    //            }
    //        }
    //        $this->render("industries", array("model" => $model));
    //    }
    //
    //    /* Update Designation */
    //
    //    public function actionUpdateDesignation($id) {
    //        $model = DesignationMaster::model()->findByPk($id);
    //        $educationModel = new DesignationEducations();
    //        $acedamicArray = Courses::model()->getAcademic();
    //        $educationArr = DesignationEducations::model()->getDesignationEducation($model->id);
    //
    //        $errorArray = array();
    //
    //        $this->performAjaxValidation($model, 'designation-form');
    //
    //        if (isset($_POST["DesignationMaster"])) {
    //            $model->attributes = $_POST["DesignationMaster"];
    //            $model->req_year_of_exp = !empty($_POST["DesignationMaster"]['req_year_of_exp']) ? $_POST["DesignationMaster"]['req_year_of_exp'] : 0;
    //
    //            $errorArray = DesignationEducations::model()->validateDesignationEduction($_POST);
    //
    //            if ($model->validate() && empty($errorArray)) {
    //                $model->update();
    //                DesignationEducations::model()->saveDesignationEducation($_POST, $model->id);
    //                Yii::app()->user->setFlash('success', 'You have successfully updated record.');
    //                $this->redirect(array("settings/designations"));
    //            }
    //        }
    //        $this->render("desingations", array("model" => $model, "educationModel" => $educationModel, 'acedamicArray' => $acedamicArray, "educationArr" => $educationArr, "errorArray" => $errorArray));
    //    }
    //
    //    /*     * Delete Designation */
    //
    //    public function actionDeleteDesignation($id) {
    //        if (Yii::app()->request->isPostRequest) {
    //            if (DesignationMaster::model()->checkDelete($id) || true) {
    //                // we only allow deletion via POST request
    //                $model = DesignationMaster::model()->findByPk($id);
    //                $model->deleted = 1;
    //                $model->update();
    //                echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully deleted record.</div>";
    //                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    //                if (!isset($_GET['ajax']))
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('designations'));
    //            }else {
    //                echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>This record is co-related to other record so it can not be deleted.</div>";
    //                Yii::app()->end();
    //            }
    //        } else
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //    }
    //
    //    /*     * update group order */
    //
    //    public function actionGroupUpOrder() {
    //        if (isset($_GET["grouporder"]) && $_GET["grouporder"] != "") {
    //            $query = "UPDATE
    //            " . MenuGroups::model()->tableName() . " AS mg1
    //            JOIN " . MenuGroups::model()->tableName() . " AS mg2 ON
    //            ( mg1.grouporder = " . $_GET["grouporder"] . " AND mg2.grouporder = " . ($_GET["grouporder"] - 1) . " )
    //            SET
    //            mg1.grouporder = mg2.grouporder,
    //            mg2.grouporder = mg1.grouporder";
    //            $command = Yii::app()->db->createCommand($query);
    //            $command->execute();
    //            echo "<div class=\"alert alert-success\">
    //                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
    //                    You have successfully updated record.
    //                </div>";
    //            if (Yii::app()->request->isAjaxRequest) {
    //                return true;
    //            } else {
    //                $this->redirect(Yii::app()->params["webUrl"] . "settings/grouplist");
    //            }
    //        }
    //    }
    //
    //    /*     * update group order */
    //
    //    public function actionGroupDownOrder() {
    //        if (isset($_GET["grouporder"]) && $_GET["grouporder"] != "") {
    //            $query = "UPDATE
    //            " . MenuGroups::model()->tableName() . " AS mg1
    //            JOIN " . MenuGroups::model()->tableName() . " AS mg2 ON
    //            ( mg1.grouporder = " . $_GET["grouporder"] . " AND mg2.grouporder = " . ($_GET["grouporder"] + 1) . " )
    //            SET
    //            mg1.grouporder = mg2.grouporder,
    //            mg2.grouporder = mg1.grouporder";
    //            $command = Yii::app()->db->createCommand($query);
    //            $command->execute();
    //            echo "<div class=\"alert alert-success\">
    //                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
    //                    You have successfully updated record.
    //                </div>";
    //            if (Yii::app()->request->isAjaxRequest) {
    //                return true;
    //            } else {
    //                $this->redirect(Yii::app()->params["webUrl"] . "settings/grouplist");
    //            }
    //        }
    //    }
    //
    //    /* Manage Documents */
    //
    //    public function actionDocuments() {
    //        $model = new DocumentsMaster();
    //        $this->performAjaxValidation($model, 'documents-form');
    //        if (isset($_POST["DocumentsMaster"])) {
    //            $model->attributes = $_POST["DocumentsMaster"];
    //            if ($model->validate()) {
    //                $model->save();
    //                Yii::app()->user->setFlash('success', 'You have successfully added record.');
    //                $this->redirect(array("settings/documents"));
    //            }
    //        }
    //        $this->render("documents", array("model" => $model));
    //    }
    //
    //    /* Update Documents */
    //
    //    public function actionUpdateDocuments($id) {
    //        $model = DocumentsMaster::model()->findByPk($id);
    //        $this->performAjaxValidation($model, 'documents-form');
    //
    //        if (isset($_POST["DocumentsMaster"])) {
    //            $model->attributes = $_POST["DocumentsMaster"];
    //            if ($model->validate()) {
    //                $model->update();
    //                Yii::app()->user->setFlash('success', 'You have successfully updated record.');
    //                $this->redirect(array("settings/documents"));
    //            }
    //        }
    //        $this->render("documents", array("model" => $model));
    //    }
    //
    //    /*     * Delete Documents */
    //
    //    public function actionDeleteDocuments($id) {
    //        if (Yii::app()->request->isPostRequest) {
    //            // we only allow deletion via POST request
    //            $model = DocumentsMaster::model()->findByPk($id);
    //            if (DocumentsMaster::model()->checkDelete($id)) {
    //                $model->deleted = 1;
    //                $model->update();
    //                echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully deleted record.</div>";
    //                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    //                if (!isset($_GET['ajax'])) {
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('documents'));
    //                }
    //            } else {
    //                echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>This record is co-related to other record so it can not be deleted.</div>";
    //                Yii::app()->end();
    //            }
    //        } else
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //    }
    //
    //    /*     * Manage Roles* */
    //
    //    public function actionRoles() {
    //        $model = new Rolemaster();
    //        $this->performAjaxValidation($model, 'roles-form');
    //
    //        if (isset($_POST["Rolemaster"])) {
    //            $model->attributes = $_POST["Rolemaster"];
    //            $model->description = !empty($_POST["Rolemaster"]['description']) ? $_POST["Rolemaster"]['description'] : "";
    //            if ($model->validate()) {
    //                $model->save();
    //                Yii::app()->user->setFlash('success', 'You have successfully added record.');
    //                $this->redirect(array("settings/roles"));
    //            }
    //        }
    //        $this->render("roles", array("model" => $model));
    //    }
    //
    //    /*     * Update Role */
    //
    //    public function actionUpdateRoles($id) {
    //        $model = Rolemaster::model()->findByPk($id);
    //        $this->performAjaxValidation($model, 'roles-form');
    //
    //        if (isset($_POST["Rolemaster"])) {
    //            $model->attributes = $_POST["Rolemaster"];
    //            $model->description = !empty($_POST["Rolemaster"]['description']) ? $_POST["Rolemaster"]['description'] : "";
    //            if ($model->validate()) {
    //                $model->update();
    //                Yii::app()->user->setFlash('success', 'You have successfully updated record.');
    //                $this->redirect(array("settings/roles"));
    //            }
    //        }
    //        $this->render("roles", array("model" => $model));
    //    }
    //
    //    /*     * Delete Role */
    //
    //    public function actionDeleteroles($id) {
    //        if (Yii::app()->request->isPostRequest) {
    //            // we only allow deletion via POST request
    //            $model = Rolemaster::model()->findByPk($id);
    //            if (Rolemaster::model()->checkDelete($id)) {
    //                $model->status = 0;
    //                $model->update();
    //                echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully deleted record.</div>";
    //                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    //                if (!isset($_GET['ajax'])) {
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('roles'));
    //                }
    //            } else {
    //                echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>This record is co-related to other record so it can not be deleted.</div>";
    //                Yii::app()->end();
    //            }
    //        } else
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //    }
    //
    //    /*     * Manage Technology */
    //
    //    public function actionTechnologies() {
    //        $model = new TechnologyMaster();
    //        $uploadPath = Yii::app()->params->technologyPath;
    //        $this->performAjaxValidation($model, 'technologies-form');
    //
    //        if (isset($_POST["TechnologyMaster"])) {
    //            $model->attributes = $_POST["TechnologyMaster"];
    //
    //            if (!empty($_FILES) && $_FILES['TechnologyMaster']['name']['image'] != "") {
    //                $model->image = time() . "_" . $_FILES['TechnologyMaster']['name']['image'];
    //                if (move_uploaded_file($_FILES['TechnologyMaster']['tmp_name']['image'], $uploadPath . $model->image)) {
    //                    $orig_file_path = $uploadPath . $model->image;
    //                    $thumb_file_path = $uploadPath . $model->ThumbSize[0] . "x" . $model->ThumbSize[1] . "_" . $model->image;
    //                    common::resizeOriginalImage($orig_file_path, $thumb_file_path, $model->ThumbSize);
    //                }
    //            }
    //            if ($model->validate()) {
    //                if ($model->save()) {
    //                    Yii::app()->user->setFlash('success', 'You have successfully added record.');
    //                } else {
    //                    Yii::app()->user->setFlash('error', 'Error in processing your request.');
    //                }
    //                $this->redirect(array("settings/technologies"));
    //            }
    //        }
    //        $this->render("technologies", array("model" => $model, "uploadPath" => $uploadPath));
    //    }
    //
    //    /*     * Update Technology */
    //
    //    public function actionUpdateTechnology($id) {
    //        $model = TechnologyMaster::model()->findByPk($id);
    //        $old_image = $model->image;
    //        $this->performAjaxValidation($model, 'technologies-form');
    //        $uploadPath = Yii::app()->params->technologyPath;
    //
    //        if (isset($_POST["TechnologyMaster"])) {
    //            $model->attributes = $_POST["TechnologyMaster"];
    //
    //            if (!empty($_FILES) && $_FILES['TechnologyMaster']['name']['image'] != "") {
    //                $model->image = time() . "_" . $_FILES['TechnologyMaster']['name']['image'];
    //                if (move_uploaded_file($_FILES['TechnologyMaster']['tmp_name']['image'], $uploadPath . $model->image)) {
    //                    $orig_file_path = $uploadPath . $model->image;
    //                    $thumb_file_path = $uploadPath . $model->ThumbSize[0] . "x" . $model->ThumbSize[1] . "_" . $model->image;
    //                    common::resizeOriginalImage($orig_file_path, $thumb_file_path, $model->ThumbSize);
    //                }
    //            } else
    //                $model->image = $old_image;
    //
    //            if ($model->validate()) {
    //                if ($model->update()) {
    //                    Yii::app()->user->setFlash('success', 'You have successfully updated record.');
    //                } else {
    //                    Yii::app()->user->setFlash('error', 'Error in processing your request.');
    //                }
    //                $this->redirect(array("settings/technologies"));
    //            }
    //        }
    //        $this->render("technologies", array("model" => $model, "uploadPath" => $uploadPath));
    //    }
    //
    //    /*     * Delete Technology */
    //
    //    public function actionDeleteTechnology($id) {
    //        if (Yii::app()->request->isPostRequest) {
    //            // we only allow deletion via POST request
    //            $model = TechnologyMaster::model()->findByPk($id);
    //            $model->deleted = 1;
    //            $model->update();
    //            echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully deleted record.</div>";
    //            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    //
    //            if (!isset($_GET['ajax']))
    //                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('technologies'));
    //        } else
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //    }
    //
    //    /*     * Manage Cities */
    //
    //    public function actionCities() {
    //        $model = new CityMaster();
    //        $this->performAjaxValidation($model, 'cities-form');
    //
    //        if (isset($_POST["CityMaster"])) {
    //            $model->attributes = $_POST["CityMaster"];
    //
    //            if ($model->validate()) {
    //                $model->save();
    //                Yii::app()->user->setFlash('success', 'You have successfully added record.');
    //                $this->redirect(array("settings/cities"));
    //            }
    //        }
    //        $this->render("cities", array("model" => $model));
    //    }
    //
    //    /** Update city */
    //    public function actionUpdateCity($id) {
    //        $model = $this->loadModel($id, "CityMaster");
    //        $this->performAjaxValidation($model, 'cities-form');
    //
    //        if (isset($_POST["CityMaster"])) {
    //            $model->attributes = $_POST["CityMaster"];
    //
    //            if ($model->validate()) {
    //                $model->update();
    //                Yii::app()->user->setFlash('success', 'You have successfully updated record.');
    //                $this->redirect(array("settings/cities"));
    //            }
    //        }
    //        $this->render("cities", array("model" => $model));
    //    }
    //
    //    /*     * Delete cities */
    //
    //    public function actionDeleteCity($id) {
    //        if (Yii::app()->request->isPostRequest) {
    //            $model = CityMaster::model()->findByPk($id);
    //            $model->deleted = 1;
    //            $model->update();
    //            echo "<div class=\"alert alert-success\">
    //                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
    //                You have successfully deleted record.
    //            </div>";
    //            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    //            if (!isset($_GET['ajax']))
    //                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('cities'));
    //        } else
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //    }
    //
    //    /*     * manage areas */
    //
    //    public function actionAreas() {
    //        $model = new AreaMaster('search');
    //        $model->scenario = 'normal';
    //
    //        if (isset($_GET['AreaMaster']))
    //            $model->attributes = $_GET['AreaMaster'];
    //
    //        $this->performAjaxValidation($model, "cities-form");
    //        if (isset($_POST["AreaMaster"])) {
    //            $model->attributes = $_POST["AreaMaster"];
    //            if ($model->validate()) {
    //                $areaid = AreaMaster::model()->addNewArea($model->country_id, $model->state_id, $model->city_id, $model->area_name, 0);
    //                // $model->save();
    //                Yii::app()->user->setFlash('success', 'You have successfully added record.');
    //                $this->redirect(array("settings/areas"));
    //            }
    //        }
    //        $this->render("areas", array("model" => $model));
    //    }
    //
    //    /** Update Area */
    //    public function actionUpdateArea($id) {
    //        $model = $this->loadModel($id, "AreaMaster");
    //        $this->performAjaxValidation($model, "form-areas");
    //        if (isset($_POST["AreaMaster"])) {
    //            $model->attributes = $_POST["AreaMaster"];
    //
    //            if ($model->validate()) {
    //                $model->update();
    //                Yii::app()->user->setFlash('success', 'You have successfully updated record.');
    //                $this->redirect(array("settings/areas"));
    //            }
    //        }
    //        $this->render("areas", array("model" => $model));
    //    }
    //
    //    /*     * Delete Area */
    //
    //    public function actionDeleteArea($id) {
    //        if (Yii::app()->request->isPostRequest) {
    //            $model = AreaMaster::model()->findByPk($id);
    //            $model->deleted = 1;
    //            $model->update();
    //            echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully deleted record.</div>";
    //            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    //            if (!isset($_GET['ajax']))
    //                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('areas'));
    //        } else
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //    }
    //
    //    /*     * Manage Teams */
    //
    //    public function actionTeams() {
    //        $model = new TeamsMaster();
    //        $this->performAjaxValidation($model, 'teams-form');
    //
    //        if (isset($_POST["TeamsMaster"])) {
    //            $model->attributes = $_POST["TeamsMaster"];
    //            //$model->project_manager_id = implode(",", $_POST["TeamsMaster"]['project_manager_id']);
    //            //$model->skills_group = implode(",", $_POST["TeamsMaster"]['skills_group']);
    //            $model->is_billable = !empty($_POST["TeamsMaster"]['skills_group']) ? true : false;
    //            if ($model->validate()) {
    //                $model->save();
    //                Yii::app()->user->setFlash('success', 'You have successfully added record.');
    //                $this->redirect(array("settings/teams"));
    //            }
    //        }
    //        $this->render("teams", array("model" => $model));
    //    }
    //
    //    /*     * Update Team */
    //
    //    public function actionUpdateTeam($id) {
    //        $model = TeamsMaster::model()->findByPk($id);
    //        $model->project_manager_id = ''; //explode(",", $model->project_manager_id);
    //        $model->skills_group = ''; //explode(",", $model->skills_group);
    //        $this->performAjaxValidation($model, 'teams-form');
    //
    //        if (isset($_POST["TeamsMaster"])) {
    //            $model->attributes = $_POST["TeamsMaster"];
    //            $model->is_billable = !empty($_POST["TeamsMaster"]['is_billable']) ? true : 0;
    //            $model->project_manager_id = ''; //implode(",", $_POST["TeamsMaster"]['project_manager_id']);
    //            $model->skills_group = ''; //implode(",", $_POST["TeamsMaster"]['skills_group']);
    //            if ($model->validate()) {
    //                $model->update();
    //                Yii::app()->user->setFlash('success', 'You have successfully updated record.');
    //                $this->redirect(array("settings/teams"));
    //            } else {
    //                echo "<pre>";
    //                print_r($model->getErrors());
    //                die;
    //            }
    //        }
    //        $this->render("teams", array("model" => $model));
    //    }
    //
    //    /**
    //     * @name 	Action for Delete teams form master
    //     * @uses	public
    //     * @author 	Alpesh Vaghela
    //     * @since 	29-04-2013
    //     */
    //    public function actionDeleteTeam($id) {
    //        if (Yii::app()->request->isPostRequest) {
    //            if (TeamsMaster::model()->checkDelete($id)) {
    //                // we only allow deletion via POST request
    //                $model = TeamsMaster::model()->findByPk($id);
    //                $model->deleted = 1;
    //                $model->update();
    //                echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully deleted record.</div>";
    //                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    //                if (!isset($_GET['ajax']))
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('teams'));
    //            }else {
    //                echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>This record is co-related to other record so it can not be deleted.</div>";
    //                Yii::app()->end();
    //            }
    //        } else
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //    }
    //
    //    /*     * Manage Employees */
    //
    //    public function actionEmployee() {
    //        $model = new Users('search');
    //        $model->unsetAttributes();  // clear any default values
    //
    //        if (isset($_GET['status'])) {
    //            $model->status = $_GET['status'];
    //        }
    //        if (isset($_GET['Users']))
    //            $model->attributes = $_GET['Users'];
    //
    //        $model->is_dedicated = !empty($_GET['Users']["is_dedicated"]) ? true : false;
    //        $model->is_free_resource = !empty($_GET['Users']["is_free_resource"]) ? true : false;
    //
    //        $this->render("employees", array("model" => $model));
    //    }
    //
    //    /*     * Change Password */
    //
    //    public function actionChangePassword() {
    //        $model = Users::model()->findByPk($_POST['user_id']);
    //        $model->scenario = 'change_password';
    //
    //        if (isset($_POST['ajax']) && $_POST['ajax'] === 'password-form') {
    //            echo CActiveForm::validate($model);
    //            Yii::app()->end();
    //        }
    //        if (isset($_POST["Users"])) {
    //            $model->password = $_POST["Users"]["password"];
    //            $model->confirm_password = $_POST["Users"]["confirm_password"];
    //
    //            if ($model->validate()) {
    //                $model->password = common::passencrypt($_POST['Users']['password']);
    //                $model->confirm_password = common::passencrypt($_POST['Users']['confirm_password']);
    //
    //                if ($model->update())
    //                    Yii::app()->user->setFlash('success', 'You have successfully change the password.');
    //                else
    //                    Yii::app()->user->setFlash('success', 'Error in change the password.');
    //            }
    //            $this->redirect(array("settings/employee"));
    //        }
    //    }
    //
    //    public function actionChangeUserPassword() {
    //
    //        $modelObj = (!common::isNumeric(Yii::app()->user->id)) ? "Clients" : "Users";
    //
    //        $model = $modelObj::model()->findByPk(Yii::app()->user->id);
    //        $model->scenario = 'change_user_password';
    //
    //        if (isset($_POST[$modelObj])) {
    //            $model->attributes = $_POST[$modelObj];
    //            $model->password = isset($_POST[$modelObj]['password']) ? $_POST[$modelObj]['password'] : "";
    //            $model->new_password = isset($_POST[$modelObj]['new_password']) ? $_POST[$modelObj]['new_password'] : "";
    //            $model->confirm_password = isset($_POST[$modelObj]['confirm_password']) ? $_POST[$modelObj]['confirm_password'] : "";
    //
    //            if (isset($_POST['ajax']) && $_POST['ajax'] === 'update-password') {
    //                echo CActiveForm::validate($model);
    //                Yii::app()->end();
    //            }
    //
    //            if ($model->validate()) {
    //                $model->password = common::passencrypt($_POST[$modelObj]['new_password']);
    //                $model->confirm_password = common::passencrypt($_POST[$modelObj]['confirm_password']);
    //                if ($model->update())
    //                    Yii::app()->user->setFlash('success', 'You have successfully change the password.');
    //                else
    //                    Yii::app()->user->setFlash('error', 'Error in change the password.');
    //
    //                $this->redirect(array("settings/changeUserPassword"));
    //            }else {
    //                //echo "<pre>"; print_r($model->getErrors());exit;
    //            }
    //        }
    //        $model->password = "";
    //        $this->render("_form_changepassword", array("model" => $model));
    //    }
    //
    //    /*     * Add Employee */
    //
    //    public function actionAddEmployee() {
    //        $model = new Users();
    //        $old_image = "";
    //        $uploadPath = Yii::app()->params->usersPath;
    //        $model->scenario = "personal_info";
    //        $model->status = Users::STATUS_ACTIVE;
    //        $this->performAjaxValidation($model, 'personal-info-form');
    //
    //        if (isset($_POST['Users'])) {
    //            $model->attributes = $_POST['Users'];
    //            $model->middlename = isset($_POST['Users']['middlename']) ? $_POST['Users']['middlename'] : "";
    //            $model->skype_name = isset($_POST['Users']['skype_name']) ? $_POST['Users']['skype_name'] : "";
    //            $model->is_hidden = isset($_POST['Users']['is_hidden']) ? $_POST['Users']['is_hidden'] : "";
    //            $model->alias = isset($_POST['Users']['alias']) ? $_POST['Users']['alias'] : "";
    //
    //            $model->reference_name = isset($_POST['Users']['reference_name']) ? $_POST['Users']['reference_name'] : "";
    //            $model->reference_contact = isset($_POST['Users']['reference_contact']) ? $_POST['Users']['reference_contact'] : "";
    //            $model->reference_designation = isset($_POST['Users']['reference_designation']) ? $_POST['Users']['reference_designation'] : "";
    //            $model->reference_name2 = isset($_POST['Users']['reference_name2']) ? $_POST['Users']['reference_name2'] : "";
    //            $model->reference_contact2 = isset($_POST['Users']['reference_contact2']) ? $_POST['Users']['reference_contact2'] : "";
    //            $model->reference_designation2 = isset($_POST['Users']['reference_designation2']) ? $_POST['Users']['reference_designation2'] : "";
    //
    //            if ($model->validate()) {
    //                $model->profile_pic = CUploadedFile::getInstance($model, 'profile_pic');
    //                $model->date_of_birth = !empty($_POST['Users']['date_of_birth']) ? common::getTimeStamp($_POST['Users']['date_of_birth']) : "";
    //                $model->marriage_anniversary = !empty($_POST['Users']['marriage_anniversary']) ? common::getTimeStamp($_POST['Users']['marriage_anniversary']) : "";
    //
    //                if (!empty($_FILES) && $_FILES['Users']['name']['profile_pic'] != "") {
    //                    $model->profile_pic = time() . "_" . $_FILES['Users']['name']['profile_pic'];
    //                    move_uploaded_file($_FILES['Users']['tmp_name']['profile_pic'], $uploadPath . $model->profile_pic);
    //                    $orig_file_path = $uploadPath . $model->profile_pic;
    //                    $thumb_file_path = $uploadPath . $model->ThumbSize[0] . "x" . $model->ThumbSize[1] . "_" . $model->profile_pic;
    //                    common::resizeOriginalImage($orig_file_path, $thumb_file_path, $model->ThumbSize);
    //                }
    //                Yii::app()->user->setFlash('success', "You have successfully create a user " . $model->firstname . " " . $model->lastname . ", Now you can update its other details also.");
    //                $model->save();
    //                $this->redirect(array("settings/updateemployee/", "id" => $model->user_id));
    //            }
    //        }
    //        $this->render("addEmployee", array("model" => $model, "old_image" => $old_image));
    //    }
    //
    //    /** Update Employee */
    //    public function actionUpdateEmployee($id) {
    //
    //        $inActiveflashmessage = "";
    //        $model = $this->loadModel($id, "Users");
    //        $model->scenario = "personal_info";
    //        $model->date_of_birth = !empty($model->date_of_birth) ? common::getDateTimeFromTimeStamp($model->date_of_birth, "d/m/Y") : $model->date_of_birth;
    //        $model->marriage_anniversary = !empty($model->marriage_anniversary) ? common::getDateTimeFromTimeStamp($model->marriage_anniversary, "d/m/Y") : $model->marriage_anniversary;
    //        $old_image = $model->profile_pic;
    //        $uploadPath = Yii::app()->params->usersPath;
    //
    //        if (isset($_POST['ajax']) && $_POST['ajax'] === 'personal-info-form') {
    //            echo CActiveForm::validate($model);
    //            Yii::app()->end();
    //        }
    //
    //        if (isset($_POST['Users'])) {
    //            $model->attributes = $_POST['Users'];
    //            $model->middlename = isset($_POST['Users']['middlename']) ? $_POST['Users']['middlename'] : "";
    //            $model->skype_name = isset($_POST['Users']['skype_name']) ? $_POST['Users']['skype_name'] : "";
    //            $model->is_hidden = isset($_POST['Users']['is_hidden']) ? $_POST['Users']['is_hidden'] : "";
    //            $model->alias = isset($_POST['Users']['alias']) ? $_POST['Users']['alias'] : "";
    //
    //            $model->reference_name = isset($_POST['Users']['reference_name']) ? $_POST['Users']['reference_name'] : "";
    //            $model->reference_contact = isset($_POST['Users']['reference_contact']) ? $_POST['Users']['reference_contact'] : "";
    //            $model->reference_designation = isset($_POST['Users']['reference_designation']) ? $_POST['Users']['reference_designation'] : "";
    //            $model->reference_name2 = isset($_POST['Users']['reference_name2']) ? $_POST['Users']['reference_name2'] : "";
    //            $model->reference_contact2 = isset($_POST['Users']['reference_contact2']) ? $_POST['Users']['reference_contact2'] : "";
    //            $model->reference_designation2 = isset($_POST['Users']['reference_designation2']) ? $_POST['Users']['reference_designation2'] : "";
    //
    //            if ($model->validate()) {
    //                $model->profile_pic = CUploadedFile::getInstance($model, 'profile_pic');
    //                $model->date_of_birth = !empty($_POST['Users']['date_of_birth']) ? common::getTimeStamp($_POST['Users']['date_of_birth']) : "";
    //                $model->marriage_anniversary = !empty($_POST['Users']['marriage_anniversary']) ? common::getTimeStamp($_POST['Users']['marriage_anniversary']) : "";
    //
    //                if (!empty($_FILES) && $_FILES['Users']['name']['profile_pic'] != "") {
    //                    $model->profile_pic = time() . "_" . $_FILES['Users']['name']['profile_pic'];
    //                    move_uploaded_file($_FILES['Users']['tmp_name']['profile_pic'], $uploadPath . $model->profile_pic);
    //                    $orig_file_path = $uploadPath . $model->profile_pic;
    //                    $thumb_file_path = $uploadPath . $model->ThumbSize[0] . "x" . $model->ThumbSize[1] . "_" . $model->profile_pic;
    //                    common::resizeOriginalImage($orig_file_path, $thumb_file_path, $model->ThumbSize);
    //                } else {
    //                    $model->profile_pic = $old_image;
    //                }
    //
    //                if (isset($_POST['Users']['status']) && $_POST['Users']['status'] == '0')
    //                    $model->status = 0;
    //
    //                $model->update();
    //                Yii::app()->user->setFlash('success', "Personal information updated successfully.");
    //                if (!empty($inActiveflashmessage)) {
    //                    if (Yii::app()->user->hasFlash('error')) {
    //                        $reMessage = Yii::app()->user->getFlash('error');
    //                        $inActiveflashmessage .= $reMessage;
    //                    }
    //                    Yii::app()->user->setFlash('error', $inActiveflashmessage);
    //                }
    //                $this->redirect(array("settings/updateemployee/", "id" => $model->user_id));
    //            }
    //        }
    //        $this->render("updateEmployee", array("model" => $model, "old_image" => $old_image));
    //    }
    //
    //    public function actionEmployeeHistory($id) {
    //        $model = Users::model()->findByPk($id);
    //        $historyModel = new UsersHistory();
    //        $errorArray = array();
    //        $historyValidate = true;
    //
    //        if (!empty($_POST['UsersHistory'])) {
    //
    //            foreach ($_POST['UsersHistory'] as $key => $value) {
    //
    //                $modelHistoryInner = new UsersHistory();
    //                $modelHistoryInner->attributes = $value;
    //                $modelHistoryInner->comments = !empty($value['comments']) ? $value['comments'] : "";
    //
    //                if (!$modelHistoryInner->validate()) {
    //                    $modelErrors = $modelHistoryInner->getErrors();
    //                    if (isset($modelErrors["company_name"][0]))
    //                        $errorArray[$key]["company_name"] = "<div class=\"errorMessage\">" . $modelErrors["company_name"][0] . "</div>";
    //                    if (isset($modelErrors["designation"][0]))
    //                        $errorArray[$key]["designation"] = "<div class=\"errorMessage\">" . $modelErrors["designation"][0] . "</div>";
    //                    if (isset($modelErrors["from_date"][0]))
    //                        $errorArray[$key]["from_date"] = "<div class=\"errorMessage\">" . $modelErrors["from_date"][0] . "</div>";
    //                    if (isset($modelErrors["to_date"][0]))
    //                        $errorArray[$key]["to_date"] = "<div class=\"errorMessage\">" . $modelErrors["to_date"][0] . "</div>";
    //                    if (isset($modelErrors["skills"][0]))
    //                        $errorArray[$key]["skills"] = "<div class=\"errorMessage\">" . $modelErrors["skills"][0] . "</div>";
    //                    if (isset($modelErrors["comments"][0]))
    //                        $errorArray[$key]["comments"] = "<div class=\"errorMessage\">" . $modelErrors["comments"][0] . "</div>";
    //                    $historyValidate = false;
    //                    break;
    //                }
    //            }
    //            if ($historyValidate == true) {
    //                $criteria = new CDbCriteria();
    //                $criteria->condition = "user_id='" . $model->user_id . "'";
    //                UsersHistory::model()->deleteAll($criteria);
    //                foreach ($_POST['UsersHistory'] as $key => $value) {
    //                    $modelHistoryInner = new UsersHistory();
    //                    $modelHistoryInner->attributes = $value;
    //                    $modelHistoryInner->comments = !empty($value['comments']) ? $value['comments'] : "";
    //                    $modelHistoryInner->user_id = $model->user_id;
    //                    $modelHistoryInner->from_date = !empty($value['from_date']) ? common::getTimeStamp($value['from_date']) : "";
    //                    $modelHistoryInner->to_date = !empty($value['to_date']) ? common::getTimeStamp($value['to_date']) : "";
    //                    $modelHistoryInner->save();
    //                }
    //                Yii::app()->user->setFlash('success', "Employee histroy details updated successfully.");
    //
    //                $this->redirect(array("settings/employeehistory/", "id" => $model->user_id));
    //            }
    //        }
    //        $this->render("updateEmployee", array("model" => $model, "historyModel" => $historyModel, "errorArray" => $errorArray));
    //    }
    //
    //    public function actionQualification($id) {
    //        $model = Users::model()->findByPk($id);
    //        $qualificationModel = new UsersQualifications();
    //        $errorArray = array();
    //        $historyValidate = true;
    //
    //        if (isset($_POST['UsersQualifications'])) {
    //            //echo "<pre>";
    //            foreach ($_POST['UsersQualifications'] as $key => $value) {
    //                //print_r($value);
    //                $modelHistoryInner = new UsersQualifications();
    //                $modelHistoryInner->attributes = $value;
    //                $modelHistoryInner->other_institute = !empty($value['other_institute']) ? $value['other_institute'] : "";
    //                $modelHistoryInner->other_university = !empty($value['other_university']) ? $value['other_university'] : "";
    //                $modelHistoryInner->other_discipline = !empty($value['other_discipline']) ? $value['other_discipline'] : "";
    //                $modelHistoryInner->other_degree = !empty($value['other_degree']) ? $value['other_degree'] : "";
    //
    //                if (!$modelHistoryInner->validate()) {
    //                    $modelErrors = $modelHistoryInner->getErrors();
    //                    if (isset($modelErrors["acedamic_id"][0]))
    //                        $errorArray[$key]["acedamic_id"] = "<div class=\"errorMessage\">" . $modelErrors["acedamic_id"][0] . "</div>";
    //                    if (isset($modelErrors["degree_id"][0]))
    //                        $errorArray[$key]["degree_id"] = "<div class=\"errorMessage\">" . $modelErrors["degree_id"][0] . "</div>";
    //                    if (isset($modelErrors["discipline_id"][0]))
    //                        $errorArray[$key]["discipline_id"] = "<div class=\"errorMessage\">" . $modelErrors["discipline_id"][0] . "</div>";
    //                    if (isset($modelErrors["university_id"][0]))
    //                        $errorArray[$key]["university_id"] = "<div class=\"errorMessage\">" . $modelErrors["university_id"][0] . "</div>";
    //                    if (isset($modelErrors["institute_id"][0]))
    //                        $errorArray[$key]["institute_id"] = "<div class=\"errorMessage\">" . $modelErrors["institute_id"][0] . "</div>";
    //                    if (isset($modelErrors["passing_year"][0]))
    //                        $errorArray[$key]["passing_year"] = "<div class=\"errorMessage\">" . $modelErrors["passing_year"][0] . "</div>";
    //                    if (isset($modelErrors["percentages"][0]))
    //                        $errorArray[$key]["percentages"] = "<div class=\"errorMessage\">" . $modelErrors["percentages"][0] . "</div>";
    //                    $historyValidate = false;
    //                    break;
    //                }
    //            }
    //        }
    //
    //        if ($historyValidate == true) {
    //            if (isset($_POST['UsersQualifications'])) {
    //                $criteria = new CDbCriteria();
    //                $criteria->condition = "user_id='" . $model->user_id . "'";
    //                UsersQualifications::model()->deleteAll($criteria);
    //                foreach ($_POST['UsersQualifications'] as $key => $value) {
    //                    $modelHistoryInner = new UsersQualifications();
    //                    $modelHistoryInner->attributes = $value;
    //                    $modelHistoryInner->other_institute = !empty($value['other_institute']) ? $value['other_institute'] : "";
    //                    $modelHistoryInner->other_university = !empty($value['other_university']) ? $value['other_university'] : "";
    //                    $modelHistoryInner->other_discipline = !empty($value['other_discipline']) ? $value['other_discipline'] : "";
    //                    $modelHistoryInner->other_degree = !empty($value['other_degree']) ? $value['other_degree'] : "";
    //
    //                    if ($modelHistoryInner->degree_id == 'O' && !empty($modelHistoryInner->other_degree)) {
    //                        $degreeModel = new Courses();
    //                        $degreeModel->name = $modelHistoryInner->other_degree;
    //                        $degreeModel->parent_id = $modelHistoryInner->acedamic_id;
    //                        $degreeModel->status = 1;
    //                        $degreeModel->level = 2;
    //                        $degreeModel->rgt = 0;
    //                        $degreeModel->lft = 0;
    //                        $degreeModel->root = 2;
    //                        $degreeModel->course_type = "D";
    //                        $degreeModel->created_dt = common::getTimeStamp();
    //                        $degreeModel->created_by = Yii::app()->user->id;
    //                        $degreeModel->updated_dt = common::getTimeStamp();
    //                        $degreeModel->updated_by = Yii::app()->user->id;
    //                        $degreeModel->save();
    //                        $modelHistoryInner->degree_id = $degreeModel->id;
    //                    }
    //                    if ($modelHistoryInner->discipline_id == 'O' && !empty($modelHistoryInner->other_discipline)) {
    //                        $desciplineModel = new Courses();
    //                        $desciplineModel->name = $modelHistoryInner->other_discipline;
    //                        $desciplineModel->parent_id = $modelHistoryInner->degree_id;
    //                        $desciplineModel->status = 1;
    //                        $desciplineModel->level = 3;
    //                        $desciplineModel->rgt = 0;
    //                        $desciplineModel->lft = 0;
    //                        $desciplineModel->root = 3;
    //                        $desciplineModel->course_type = "S";
    //                        $desciplineModel->created_dt = common::getTimeStamp();
    //                        $desciplineModel->created_by = Yii::app()->user->id;
    //                        $desciplineModel->updated_dt = common::getTimeStamp();
    //                        $desciplineModel->updated_by = Yii::app()->user->id;
    //                        $desciplineModel->save();
    //                        $modelHistoryInner->discipline_id = $desciplineModel->id;
    //                    }
    //
    //                    if ($modelHistoryInner->university_id == 'O' && !empty($modelHistoryInner->other_university)) {
    //                        $universityModel = new University();
    //                        $universityModel->university_name = $modelHistoryInner->other_university;
    //                        $universityModel->status = 1;
    //                        $universityModel->created_dt = common::getTimeStamp();
    //                        $universityModel->created_by = Yii::app()->user->id;
    //                        $universityModel->updated_dt = common::getTimeStamp();
    //                        $universityModel->updated_by = Yii::app()->user->id;
    //                        $universityModel->save();
    //                        $modelHistoryInner->university_id = $universityModel->id;
    //                    }
    //
    //                    if ($modelHistoryInner->institute_id == 'O' && !empty($modelHistoryInner->other_institute)) {
    //                        $instituteModel = new Institute();
    //                        $instituteModel->university_id = $modelHistoryInner->university_id;
    //                        $instituteModel->institute_name = $modelHistoryInner->other_institute;
    //                        $instituteModel->status = 1;
    //                        $instituteModel->created_dt = common::getTimeStamp();
    //                        $instituteModel->created_by = Yii::app()->user->id;
    //                        $instituteModel->updated_dt = common::getTimeStamp();
    //                        $instituteModel->updated_by = Yii::app()->user->id;
    //                        $instituteModel->save();
    //                        $modelHistoryInner->institute_id = $instituteModel->id;
    //                    }
    //
    //                    $modelHistoryInner->user_id = $model->user_id;
    //
    //                    $modelHistoryInner->save();
    //                }
    //                Yii::app()->user->setFlash('success', "Employee qualifications details updated successfully.");
    //                $this->redirect(array("settings/qualification/", "id" => $model->user_id));
    //            }
    //        }
    //        $this->render("updateEmployee", array("model" => $model, "qualificationModel" => $qualificationModel, "errorArray" => $errorArray));
    //    }
    //
    //    public function actionReportings($id) {
    //
    //        $model = Users::model()->findByPk($id);
    //        /* get yearly leaves */
    //        $model->allowed_leaves = UsersYearlyLeaves::model()->getUserYearlyLeaves($model->user_id);
    //        $old_leave_count = $model->allowed_leaves;
    //
    //        $old_employee_status = $model->employee_status;
    //        $model->scenario = "reporting";
    //
    //        $model->joining_date = !empty($model->joining_date) ? common::getDateTimeFromTimeStamp($model->joining_date, "d/m/Y") : $model->joining_date;
    //        $model->resignation_date = !empty($model->resignation_date) ? common::getDateTimeFromTimeStamp($model->resignation_date, "d/m/Y") : $model->resignation_date;
    //        $model->permenent_from_date = !empty($model->permenent_from_date) ? common::getDateTimeFromTimeStamp($model->permenent_from_date, "d/m/Y") : $model->joining_date;
    //
    //        if (isset($_POST['ajax']) && $_POST['ajax'] === 'reportings-form') {
    //            echo CActiveForm::validate($model);
    //            Yii::app()->end();
    //        }
    //
    //        if (isset($_POST['Users'])) {
    //            $model->attributes = $_POST['Users'];
    //            $model->is_tl = !empty($_POST['Users']['is_tl']) ? 1 : 0;
    //            $model->is_billable = !empty($_POST['Users']['is_billable']) ? 1 : 0;
    //            $model->allowed_leaves = !empty($_POST['Users']['allowed_leaves']) ? $_POST['Users']['allowed_leaves'] : "";
    //            $model->branch_id = !empty($_POST['Users']['branch_id']) ? $_POST['Users']['branch_id'] : AccountBranchMaster::model()->getDefaultBranchID($model->company_id);
    //            //comma seperated values of users' group
    //            $model->user_group = (count($_POST['Users']['user_group']) > 1) ? implode(',', $_POST['Users']['user_group']) : $_POST['Users']['user_group'][0];
    //            if (isset($_POST['Users']['module_id'])) {
    //                $model->module_id = (count($_POST['Users']['module_id']) > 1) ? implode(',', $_POST['Users']['module_id']) : $_POST['Users']['module_id'][0];
    //            }else{
    //                $model->module_id='';
    //            }
    //            if ($model->validate()) {
    //                $model->joining_date = !empty($_POST['Users']['joining_date']) ? common::getTimeStamp($_POST['Users']['joining_date']) : "";
    //                $model->resignation_date = !empty($_POST['Users']['resignation_date']) ? common::getTimeStamp($_POST['Users']['resignation_date']) : "";
    //                $model->permenent_from_date = !empty($_POST['Users']['permenent_from_date']) ? common::getTimeStamp($_POST['Users']['permenent_from_date']) : "";
    //
    //                if ($model->employee_status != 3) {
    //                    $model->permenent_from_date = "";
    //                }
    //
    //                /* SET EMPLOYEE PERMENENT DATE */
    //                if ($old_employee_status != $model->employee_status && $model->employee_status == 3) {
    //                    $model->permenent_from_date = !empty($_POST['Users']['permenent_from_date']) ? common::getTimeStamp($_POST['Users']['permenent_from_date']) : "";
    //                    /* UPDATE USERS TOTAL LEAVES */
    //                    $year = common::getDateTimeFromTimeStamp($model->permenent_from_date, "Y");
    //
    //                    $usersLeaveModel = new UsersYearlyLeaves();
    //                    $usersLeaveModel->user_id = $model->user_id;
    //                    $usersLeaveModel->year = $year;
    //                    $usersLeaveModel->allowed_leaves = $model->allowed_leaves;
    //                    $usersLeaveModel->save();
    //
    //                    $this->updateLeavesAppliedInDuration($model); // update leave taken before probation date
    //
    //                    /* UPDATE USERS TOTAL LEAVES */
    //                } else if ($model->allowed_leaves != $old_leave_count && $model->employee_status == 3) {
    //                    /* UPDATE USERS TOTAL LEAVES */
    //                    $year = common::getDateTime("now", "Y");
    //                    $criteria = new CDbCriteria();
    //                    $criteria->condition = "t.user_id='" . $model->user_id . "' AND t.year = '" . $year . "'";
    //                    $usersLeaveModel = UsersYearlyLeaves::model()->find($criteria);
    //                    if (!is_object($usersLeaveModel)) {
    //                        $userLeaveModelInsert = new UsersYearlyLeaves();
    //                        $userLeaveModelInsert->year = $year;
    //                        $userLeaveModelInsert->user_id = $model->user_id;
    //                        $userLeaveModelInsert->allowed_leaves = 0;
    //                        $userLeaveModelInsert->save();
    //
    //                        $criteria = new CDbCriteria();
    //                        $criteria->condition = "t.user_id='" . $model->user_id . "' AND t.year = '" . $year . "'";
    //                        $usersLeaveModel = UsersYearlyLeaves::model()->find($criteria);
    //                    }
    //                    $usersLeaveModelUpdate = UsersYearlyLeaves::model()->findByPk($usersLeaveModel->id);
    //                    $usersLeaveModelUpdate->allowed_leaves = $model->allowed_leaves;
    //                    $usersLeaveModelUpdate->update();
    //                    /* UPDATE USERS TOTAL LEAVES */
    //                }
    //                /* SET EMPLOYEE PERMENENT DATE */
    //
    //                $model->updated_dt = common::getTimeStamp();
    //                $model->updated_by = Yii::app()->user->id;
    //                $model->update();
    //                Yii::app()->user->setFlash('success', "Reporting details updated successfully.");
    //                $this->redirect(array("settings/reportings/", "id" => $model->user_id));
    //            }
    //        }
    //        $model->user_group = !empty($model->user_group) ? @explode(',', $model->user_group) : " ";
    //        $model->module_id = !empty($model->module_id) ? @explode(',', $model->module_id) : " ";
    //        $this->render("updateEmployee", array("model" => $model));
    //    }
    //
    //    public function updateLeavesAppliedInDuration($model) {
    //        Leaves::model()->updateAll(array('in_probation' => 0), 'end_date>:end_date AND user_id=:user_id', array(':end_date' => $model->permenent_from_date, ":user_id" => $model->user_id));
    //    }
    //
    //    /**
    //     * @name 	Action for getLeaveCount
    //     * @uses	to get leave count according to permenent_from_date
    //     */
    //    public function actiongetLeaveCount($id) {
    //        $model = Users::model()->findByPk($id);
    //        $model->permenent_from_date = !empty($_POST['permenent_from_date']) ? common::getTimeStamp($_POST['permenent_from_date']) : "";
    //        /* UPDATE USERS TOTAL LEAVES */
    //        $year = common::getDateTimeFromTimeStamp($model->permenent_from_date, "Y");
    //        $month = common::getDateTimeFromTimeStamp($model->permenent_from_date, "m");
    //        $totalRemainingMonths = (13 - $month);  // INCLUDING CURRENT MONTH;
    //        $leaveAllowedPerMonth = (Yii::app()->params->totalLeavesPerYear) / 12;
    //        $model->allowed_leaves = $totalRemainingMonths * $leaveAllowedPerMonth;
    //
    //        echo $model->allowed_leaves;
    //    }
    //
    //    public function actionEmployeeDocuments($id) {
    //        $model = Users::model()->findByPk($id);
    //        $documenModel = new UserDocuments();
    //        $uploadPath = Yii::app()->params->documentsPath;
    //        $documentsValidate = true;
    //        $documentErrorArr = array();
    //
    //        if (!empty($_POST['UserDocuments'])) {
    //            foreach ($_POST['UserDocuments'] as $key => $value) {
    //                $modelDocumentInner = new UserDocuments();
    //                $modelDocumentInner->document_id = !empty($value['document_id']) ? $value['document_id'] : "";
    //                if (!empty($_FILES['UserDocuments']['name'][$key]['original_name'])) {
    //                    $directoryPath = $uploadPath . $model->user_id . "/";
    //                    if (!is_dir($directoryPath))
    //                        mkdir($directoryPath);
    //
    //                    $modelDocumentInner->original_name = $_FILES['UserDocuments']['name'][$key]['original_name'];
    //                    $modelDocumentInner->server_name = time() . "_" . str_replace(" ", "_", $modelDocumentInner->original_name);
    //                }
    //                if (!$modelDocumentInner->validate()) {
    //                    $modelErrors = $modelDocumentInner->getErrors();
    //                    if (isset($modelErrors["document_id"][0]))
    //                        $documentErrorArr[$key]["document_id"] = "<div class=\"errorMessage\">" . $modelErrors["document_id"][0] . "</div>";
    //                    if (isset($modelErrors["original_name"][0]))
    //                        $documentErrorArr[$key]["original_name"] = "<div class=\"errorMessage\">File can not blank.</div>";
    //                } else {
    //                    $modelDocumentInner->created_dt = common::getTimeStamp();
    //                    $modelDocumentInner->created_by = Yii::app()->user->id;
    //                    $modelDocumentInner->user_id = $model->user_id;
    //                    $modelDocumentInner->updated_dt = 0;
    //                    $modelDocumentInner->updated_by = 0;
    //                    move_uploaded_file($_FILES['UserDocuments']['tmp_name'][$key]['original_name'], $directoryPath . $modelDocumentInner->server_name);
    //                    $modelDocumentInner->save();
    //                    Yii::app()->user->setFlash('success', "Employee documents updated successfully.");
    //                }
    //            }
    //        } else {
    //            if (!empty($_POST)) {
    //                $this->redirect(array("settings/employeedocuments/", "id" => $model->user_id));
    //            }
    //        }
    //        $this->render("updateEmployee", array("model" => $model, "documentErrorArr" => $documentErrorArr));
    //    }
    //
    //    public function actionLoginInfo($id) {
    //        $model = Users::model()->findByPk($id);
    //        if (empty($model->password)) {
    //            $model->scenario = "login";
    //        } else {
    //            $model->scenario = "udpate-login";
    //        }
    //
    //        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
    //            echo CActiveForm::validate($model);
    //            Yii::app()->end();
    //        }
    //
    //        if (isset($_POST['Users'])) {
    //            $model->attributes = $_POST['Users'];
    //            if ($model->validate()) {
    //                $model->password = !empty($_POST['Users']['password']) ? common::passencrypt($_POST['Users']['password']) : $model->password;
    //                $model->confirm_password = !empty($_POST['Users']['confirm_password']) ? common::passencrypt($_POST['Users']['confirm_password']) : $model->confirm_password;
    //                $model->updated_dt = common::getTimeStamp();
    //                $model->updated_by = Yii::app()->user->id;
    //                $model->update();
    //                Yii::app()->user->setFlash('success', "You have updated the record successfully.");
    //                $this->redirect(array("settings/employee"));
    //            }
    //        }
    //        $this->render("updateEmployee", array("model" => $model));
    //    }
    //
    //    public function actionDownloads($id) {
    //        $downloads = UserDocuments::model()->findByPk($id);
    //        $downloadRight = (!empty($downloads->user_id) && $downloads->user_id == Yii::app()->user->id) ? true : false;
    //        $downloadRight = ($this->isSuperAdmin || $this->isHumanResource) ? true : $downloadRight;
    //
    //        if ($downloadRight && is_object($downloads)) {
    //            common::Download(Yii::app()->params->documentsPath . $downloads->user_id . "/", $downloads->server_name);
    //        } else {
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //        }
    //    }
    //
    //    public function actionRemove($id) {
    //        if (Yii::app()->request->isPostRequest) {
    //            // we only allow deletion via POST request
    //            $model = UserDocuments::model()->findByPk($id);
    //            if (file_exists(Yii::app()->params->documentsPath . $model->user_id . "/" . $model->server_name)) {
    //                unlink(Yii::app()->params->documentsPath . $model->user_id . "/" . $model->server_name);
    //            }
    //            $model->delete();
    //            echo "<div class=\"alert alert-success\">
    //			<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
    //			You have successfully deleted record.
    //			</div>";
    //        } else
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //    }
    //
    //    /*     * Delete users */
    //
    //    public function actionDeleteEmployee($id) {
    //
    //        if (Yii::app()->request->isPostRequest) {
    //            // we only allow deletion via POST request
    //            $model = Users::model()->findByPk($id);
    //            $model->deleted = 1;
    //            $model->update();
    //
    //
    //            echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully deleted record.</div>";
    //            if (!isset($_GET['ajax']))
    //                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('employee'));
    //        } else
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //    }
    //
    //    /* Delete email */
    //
    //    public function actionDeleteEmail($id) {
    //        if (Yii::app()->request->isPostRequest) {
    //            // we only allow deletion via POST request	    
    //            $model = $this->loadModel($id, "EmailMaster");
    //            $model->deleted = true;
    //            $model->update();
    //            echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully deleted record.</div>";
    //            if (!isset($_GET['ajax']))
    //                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('employee'));
    //        } else
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //    }
    //
    //    /** Manage Email */
    //    public function actionEmail() {
    //        $model = new EmailMaster();
    //        $this->render("email", array("model" => $model));
    //    }
    //
    //    /** Add Email */
    //    public function actionAddEmail() {
    //        $model = new EmailMaster();
    //
    //        if (isset($_POST["EmailMaster"])) {
    //            $model->unsetAttributes();  // clear any default values
    //            $model->attributes = $_POST["EmailMaster"];
    //            $model->email_to = isset($_POST["EmailMaster"]['email_to']) ? $_POST["EmailMaster"]['email_to'] : "";
    //            $model->keywords = isset($_POST["EmailMaster"]['keywords']) ? $_POST["EmailMaster"]['keywords'] : "";
    //            $model->content = isset($_POST["EmailMaster"]['content']) ? $_POST["EmailMaster"]['content'] : "";
    //            $model->email_to_all = isset($_POST["EmailMaster"]['email_to_all']) ? $_POST["EmailMaster"]['email_to_all'] : 0;
    //
    //            $this->performAjaxValidation($model, 'email-form');
    //
    //            if ($model->validate()) {
    //                $model->profile_id = 0;
    //                $model->save();
    //                Yii::app()->user->setFlash('success', 'You have successfully added record.');
    //                $this->redirect(array("email"));
    //            }
    //        }
    //
    //        $this->render("addEmail", array("model" => $model));
    //    }
    //
    //    /*     * Update Email */
    //
    //    public function actionUpdateEmail($id) {
    //        $model = EmailMaster::model()->findByPk($id);
    //
    //        if (isset($_POST["EmailMaster"])) {
    //            $model->attributes = $_POST["EmailMaster"];
    //
    //            $model->email_to = isset($_POST["EmailMaster"]['email_to']) ? $_POST["EmailMaster"]['email_to'] : $model->email_to;
    //            $model->keywords = isset($_POST["EmailMaster"]['keywords']) ? $_POST["EmailMaster"]['keywords'] : $model->keywords;
    //            $model->content = isset($_POST["EmailMaster"]['content']) ? $_POST["EmailMaster"]['content'] : $model->content;
    //            $model->email_to_all = isset($_POST["EmailMaster"]['email_to_all']) ? $_POST["EmailMaster"]['email_to_all'] : 0;
    //
    //            $this->performAjaxValidation($model, 'email-form');
    //
    //            if ($model->validate()) {
    //                $model->update();
    //                Yii::app()->user->setFlash('success', 'You have successfully updated record.');
    //                $this->redirect(array("email"));
    //            }
    //        }
    //        $this->render("updateEmail", array("model" => $model));
    //    }
    //
    //    /** View Email Template */
    //    public function actionViewEmail($id) {
    //        $model = EmailMaster::model()->findByPk($id);
    //        echo $this->renderPartial("_view_email", array("model" => $model));
    //    }
    //
    //    /* view email log */
    //
    //    public function actionViewEmailLog($id) {
    //        $model = EmailArchive::model()->findByPk($id);
    //        echo $this->renderPartial("_view_emaillog", array("model" => $model));
    //    }
    //
    //    /** Delete Email Log */
    //    public function actionDeleteEmailLog($id) {
    //        if (Yii::app()->request->isPostRequest) {
    //            // we only allow deletion via POST request
    //            $model = EmailArchive::model()->findByPk($id);
    //            $model->delete();
    //            echo "<div class=\"alert alert-success\">
    //                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
    //                    You have successfully deleted record.
    //                </div>";
    //            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    //
    //            if (!isset($_GET['ajax']))
    //                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('email'));
    //        } else
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //    }
    //
    //    /**
    //     * @Name uploadFile
    //     * @Use Use for AJAX File Upload
    //     * @param
    //     * @author Khushbu Ajmera
    //     * @since 17-7-2013
    //     */
    //    public function actionuploadFile() {
    //        Yii::import("ext.EAjaxUpload.qqFileUploader");
    //        $id = Yii::app()->user->id;
    //        $model = Users::model()->findByPk($id);
    //        if (isset($_REQUEST["qqfile"])) {
    //            $_REQUEST["qqfile"] = common::ReplaceNonAlphaNumericChars($_REQUEST["qqfile"]);
    //        }
    //        $folder = Yii::app()->params['tempPath'];
    //        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    //        $sizeLimit = 2 * 1024 * 1024;
    //        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
    //        $result = $uploader->handleUpload($folder);
    //
    //        $fileName = $result['filename'];
    //        $orig_file_path = Yii::app()->params["uploadUrl"] . "temp/" . $result['filename'];
    //        $thumb_file_path = Yii::app()->params["tempPath"] . $model->ThumbSize[0] . "x" . $model->ThumbSize[1] . "_temp_thumb_" . $result['filename'];
    //        common::resizeOriginalImage($orig_file_path, $thumb_file_path, $model->ThumbSize);
    //        $result = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    //        echo $result;
    //        exit;
    //    }
    //
    //    public function actionEmailLog() {
    //        $model = new EmailArchive();
    //        if (isset($_GET['EmailArchive'])) {
    //            $model->attributes = $_GET['EmailArchive'];
    //            $model->id = isset($_GET['EmailArchive']['id']) ? $_GET['EmailArchive']['id'] : '';
    //        }
    //        $this->render("emailLog", array("model" => $model));
    //    }
    //
    //    /**
    //     * @name 	Action for currency master
    //     * @uses	public
    //     * @author 	Alpesh Vaghela
    //     * @since 	25-07-2013
    //     */
    //    public function actionCurrency() {
    //        $model = new CurrencyMaster();
    //        $this->performAjaxValidation($model, 'currency-form');
    //
    //        if (isset($_POST["CurrencyMaster"])) {
    //            $model->attributes = $_POST["CurrencyMaster"];
    //            $model->created_dt = common::getTimeStamp();
    //            $model->created_by = Yii::app()->user->id;
    //            $model->updated_dt = common::getTimeStamp();
    //            $model->updated_by = Yii::app()->user->id;
    //            if ($model->validate()) {
    //                $model->save();
    //                Yii::app()->user->setFlash('success', 'You have successfully added record.');
    //                $this->redirect(array("settings/currency"));
    //            }
    //        }
    //        $this->render("currency", array("model" => $model));
    //    }
    //
    //    /**
    //     * @name 	Action for Update currency.
    //     * @uses	public
    //     * @author 	Alpesh Vaghela
    //     * @since 	25-07-2013
    //     */
    //    public function actionUpdateCurrency($id) {
    //        $model = CurrencyMaster::model()->findByPk($id);
    //        $oldModel = $model;
    //
    //        $this->performAjaxValidation($model, 'currency-form');
    //
    //        if (isset($_POST["CurrencyMaster"])) {
    //            $model->attributes = $_POST["CurrencyMaster"];
    //            $model->updated_dt = common::getTimeStamp();
    //            $model->updated_by = Yii::app()->user->id;
    //
    //            if ($model->validate()) {
    //                CurrencyAudit::model()->createLog($model, $oldModel); // CREATE LOG 
    //                $model->update();
    //                Yii::app()->user->setFlash('success', 'You have successfully updated record.');
    //                $this->redirect(array("settings/currency"));
    //            }
    //        }
    //        $this->render("currency", array("model" => $model));
    //    }
    //
    //    /**
    //     * @name 	Update currency amount basic
    //     * @uses	public
    //     * @author 	Alpesh Vaghela
    //     * @since 	22-01-2015
    //     */
    //    public function actionUpdateBasicAmount() {
    //        $model = CurrencyMaster::model()->findByPk(CurrencyMaster::CURRENCY_INR);
    //        $model->scenario = "updatebasicamount";
    //        $oldModel = $model;
    //
    //        if (isset($_POST['CurrencyMaster'])) {
    //            //common::pr($_POST); exit;
    //            $model->attributes = $_POST['CurrencyMaster'];
    //            $model->amount_usd_equal_inr = !empty($_POST['CurrencyMaster']["amount_usd_equal_inr"]) ? $_POST['CurrencyMaster']["amount_usd_equal_inr"] : 0;
    //            $model->amount_eur_equal_inr = !empty($_POST['CurrencyMaster']["amount_eur_equal_inr"]) ? $_POST['CurrencyMaster']["amount_eur_equal_inr"] : 0;
    //            $decimal = 3;
    //            if (isset($_POST['ajax']) && $_POST['ajax'] === 'currency-amount-form') {
    //                echo CActiveForm::validate($model);
    //                Yii::app()->end();
    //            }
    //            if ($model->validate()) {
    //                /* SET INR */
    //                $model->current_indian_value = 1;
    //                $model->current_usd_value = common::setNumberFormat($model->current_indian_value / $model->amount_usd_equal_inr, "", $decimal);
    //                $model->current_euro_value = common::setNumberFormat($model->current_indian_value / $model->amount_eur_equal_inr, "", $decimal);
    //                $model->updated_dt = common::getTimeStamp();
    //                $model->updated_by = Yii::app()->user->id;
    //                if ($model->update()) {
    //                    CurrencyAudit::model()->createLog($model, $oldModel); // CREATE LOG 
    //                }
    //                /* SET INR */
    //
    //                /* SET USD */
    //                $updateUSD = CurrencyMaster::model()->findByPk(CurrencyMaster::CURRENCY_USD);
    //                $oldModel = $updateUSD;
    //                $updateUSD->current_indian_value = $model->amount_usd_equal_inr;
    //                $updateUSD->current_usd_value = 1;
    //                $updateUSD->current_euro_value = common::setNumberFormat($model->amount_usd_equal_inr / $model->amount_eur_equal_inr, "", $decimal);
    //                $updateUSD->updated_dt = common::getTimeStamp();
    //                $updateUSD->updated_by = Yii::app()->user->id;
    //                //common::pr($updateUSD->attributes);exit;
    //                if ($updateUSD->update()) {
    //                    CurrencyAudit::model()->createLog($updateUSD, $oldModel); // CREATE LOG 
    //                }
    //                /* SET USD */
    //
    //                /* SET EUR */
    //                $updateEUR = CurrencyMaster::model()->findByPk(CurrencyMaster::CURRENCY_EURO);
    //                $oldModel = $updateEUR;
    //                $updateEUR->current_indian_value = $model->amount_eur_equal_inr;
    //                $updateEUR->current_usd_value = common::setNumberFormat($model->amount_eur_equal_inr / $model->amount_usd_equal_inr, "", $decimal);
    //                $updateEUR->current_euro_value = 1;
    //                $updateEUR->updated_dt = common::getTimeStamp();
    //                $updateEUR->updated_by = Yii::app()->user->id;
    //                //common::pr($updateEUR->attributes);exit;
    //                if ($updateEUR->update()) {
    //                    CurrencyAudit::model()->createLog($updateEUR, $oldModel); // CREATE LOG 
    //                }
    //                /* SET EUR */
    //                Yii::app()->user->setFlash('success', 'Currencies updated successfully.');
    //            } else {
    //                Yii::app()->user->setFlash('error', 'Error in processing request.');
    //            }
    //        } else {
    //            Yii::app()->user->setFlash('error', 'Invalid access.');
    //        }
    //        $this->redirect(array("settings/currency"));
    //    }
    //
    //    /**
    //     * @name 	Action for Delete currency form master
    //     * @uses	public
    //     * @author 	Alpesh Vaghela
    //     * @since 	25-07-2013
    //     */
    //    public function actionDeleteCurrency($id) {
    //        if (Yii::app()->request->isPostRequest) {
    //            // we only allow deletion via POST request
    //            $model = CurrencyMaster::model()->findByPk($id);
    //            $model->deleted = 1;
    //            $model->update();
    //            echo "<div class=\"alert alert-success\">
    //                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
    //                    You have successfully deleted record.
    //                </div>";
    //            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    //
    //            if (!isset($_GET['ajax']))
    //                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('currency'));
    //        } else
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //    }
    //
    //    /**
    //     * @name 	Action for view organization chart
    //     * @uses	public
    //     * @author 	Alpesh Vaghela
    //     * @since 	07-10-2013
    //     */
    //    public function actionOrganizationChart() {
    //        $options = Users::model()->getOrganizationHierarchy();
    //        $this->render("organization_chart", array("options" => $options));
    //    }
    //
    //    public function actionViewEmployee($id) {
    //        $model = Users::model()->findByPk($id);
    //        $this->render("_view_employee", array("model" => $model));
    //    }
    //
    //    public function actionViewProfile($id = "") {
    //        $id = !empty($id) ? $id : Yii::app()->user->id;
    //        $model = $this->loadModel($id, "Users");
    //        $old_image = $model->profile_pic;
    //
    //        if ($model->user_id != Yii::app()->user->id && !common::checkActionAccess("settings/viewemployee")) {
    //            throw new CHttpException(403, 'You are not authorized to perform this action.');
    //        }
    //        $this->performAjaxValidation($model, "Update-profile");
    //
    //        if (isset($_POST["Users"])) {
    //            /*             * ****************************Upload profile picture******************************* */
    //            if (isset($_POST["Users"]['orig_name']) && isset($_POST["Users"]['srvr_name'])) {
    //                $original_file_name = common::ReplaceNonAlphaNumericChars($_POST["Users"]['orig_name']);
    //                $server_file_name = common::ReplaceNonAlphaNumericChars($_POST["Users"]['srvr_name']);
    //
    //                if ($server_file_name != "" && $original_file_name != "") {
    //                    $tempFile = Yii::app()->params['tempPath'] . $original_file_name;
    //                    $tempThumbFile = Yii::app()->params['tempPath'] . $server_file_name;
    //
    //                    $time = time();
    //                    $fullName = $time . "_" . $original_file_name;
    //                    $fullImage = Yii::app()->params->usersPath . $fullName;
    //
    //                    copy($tempFile, $fullImage);
    //                    @unlink($tempFile);
    //                    $thumbName = str_replace('temp_thumb', $time, $server_file_name);
    //
    //                    $thumbImage = Yii::app()->params->usersPath . $thumbName;
    //                    copy($tempThumbFile, $thumbImage);
    //                    @unlink($tempThumbFile);
    //                    $model->profile_pic = $fullName;
    //                    if (is_file(Yii::app()->params->usersPath . $old_image)) {
    //                        @unlink(Yii::app()->params->usersPath . $old_image);
    //                    }
    //                    if (Yii::app()->params->usersPath . $model->ThumbSize[0] . "x" . $model->ThumbSize[1] . "_" . $old_image) {
    //                        @unlink(Yii::app()->params->usersPath . $model->ThumbSize[0] . "x" . $model->ThumbSize[1] . "_" . $old_image);
    //                    }
    //                }
    //            }
    //            /*             * ****************************Upload profile picture******************************* */
    //            $model->attributes = $_POST["Users"];
    //            if ($model->validate()) {
    //                $model->update();
    //                Yii::app()->user->setFlash('success', 'You have successfully updated record.');
    //                if (empty($model->profile_pic) == "") {
    //                    $imageName = Users::model()->createProfilePicture($model);
    //                    $model->profile_pic = $imageName;
    //                }
    //                Yii::app()->user->setState('profile_pic', $model->profile_pic);
    //                $this->redirect(Yii::app()->user->returnUrl);
    //            } else {
    //                print_r($model->getErrors());
    //                exit;
    //            }
    //        }
    //        $this->render("view_profile", array("model" => $model));
    //    }
    //
    //    /* action for manage skills */
    //
    //    public function actionSkills($id = "") {
    //        $searchModel = new SkillsGroup('search');
    //
    //        $model = !empty($id) ? SkillsGroup::model()->findByPk($id) : new SkillsGroup();
    //        if (isset($_POST['SkillsGroup'])) {
    //            $model->attributes = $_POST['SkillsGroup'];
    //            if (isset($_POST['ajax']) && $_POST['ajax'] === 'skills-group-form') {
    //                echo CActiveForm::validate($model);
    //                Yii::app()->end();
    //            }
    //            if ($model->validate()) {
    //                if (!$model->isNewRecord) {
    //                    $model->updated_by = Yii::app()->user->id;
    //                    $model->updated_dt = common::getTimeStamp();
    //                    $model->update();
    //                    Yii::app()->user->setFlash('success', 'You have successfully updated the record.');
    //                } else {
    //                    $model->created_by = Yii::app()->user->id;
    //                    $model->created_dt = common::getTimeStamp();
    //                    $model->save();
    //                    Yii::app()->user->setFlash('success', 'You have successfully added the record.');
    //                }
    //                $this->redirect(array("settings/skills"));
    //            }
    //        }
    //        $this->render("skills_group", array("model" => $model, "searchModel" => $searchModel));
    //    }
    //
    //    /* action for manage skills */
    //
    //    public function actionSkillsMaster($id, $skill_id = "") {
    //        $this->layout = '//layouts/iframe';
    //        $searchModel = new SkillsMaster('search');
    //        $searchModel->group_id = $id;
    //        $model = !empty($skill_id) ? SkillsMaster::model()->findByPk($skill_id) : new SkillsMaster();
    //        if (isset($_POST['SkillsMaster'])) {
    //            $model->attributes = $_POST['SkillsMaster'];
    //            $model->group_id = $id;
    //            if (isset($_POST['ajax']) && $_POST['ajax'] === 'skills-master-form') {
    //                echo CActiveForm::validate($model);
    //                Yii::app()->end();
    //            }
    //            if ($model->validate()) {
    //                if (!$model->isNewRecord) {
    //                    $model->updated_by = Yii::app()->user->id;
    //                    $model->updated_dt = common::getTimeStamp();
    //                    Yii::app()->user->setFlash('success', 'You have successfully updated the record.');
    //                    $model->update();
    //                } else {
    //                    $model->created_by = Yii::app()->user->id;
    //                    $model->created_dt = common::getTimeStamp();
    //                    Yii::app()->user->setFlash('success', 'You have successfully added the record.');
    //                    $model->save();
    //                }
    //                $this->redirect(array("settings/skillsmaster", "id" => $id));
    //            }
    //        }
    //        $this->render("skills_master_index", array("model" => $model, "searchModel" => $searchModel));
    //    }
    //
    //    /* action for skills group deletion */
    //
    //    public function actionDeleteSkillGroup($id) {
    //        if (Yii::app()->request->isPostRequest) {
    //            if (SkillsGroup::model()->checkDelete($id)) {
    //                // we only allow deletion via POST request
    //                $model = SkillsGroup::model()->findByPk($id);
    //                $model->deleted = 1;
    //                $model->update();
    //                echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully deleted record.</div>";
    //                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    //                if (!isset($_GET['ajax']))
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('skills'));
    //            }else {
    //                echo "<div class=\"alert alert-error\">
    //                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
    //                   This record is co-related to other record so it can not be deleted.
    //                </div>";
    //                Yii::app()->end();
    //            }
    //        } else
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //    }
    //
    //    /* action for skills master deletion */
    //
    //    public function actionDeleteSkillsMaster($id) {
    //        if (Yii::app()->request->isPostRequest) {
    //            // we only allow deletion via POST request
    //            $model = SkillsMaster::model()->findByPk($id);
    //            $model->deleted = 1;
    //            $model->update();
    //            echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>You have successfully deleted record.</div>";
    //            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    //            if (!isset($_GET['ajax']))
    //                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('skills'));
    //        } else
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //    }
    //
    //    /* unblock user */
    //
    //    public function actionUnblock($id) {
    //        $user = Users::model()->findByPk($id);
    //        if ($user) {
    //            LoginAttempts::model()->resetLoginAttempts(array(), $user->user_id);
    //            echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>" . "  User unblocked successfully.</div>";
    //        } else {
    //            echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>" . "  User not found.</div>";
    //        }
    //    }
    //
    //    /* Manage SMS */
    //
    //    public function actionSMS() {
    //        $model = new SmsMaster();
    //        $this->render("sms", array("model" => $model));
    //    }
    //
    //    /* Add SMS */
    //
    //    public function actionAddSMS() {
    //        $model = new SmsMaster();
    //
    //        if (isset($_POST["SmsMaster"])) {
    //            $model->unsetAttributes();  // clear any default values
    //            $model->attributes = $_POST["SmsMaster"];
    //            $this->performAjaxValidation($model, 'sms-form');
    //
    //            if ($model->validate()) {
    //                $model->created_dt = common::getTimeStamp();
    //                $model->updated_dt = common::getTimeStamp();
    //                $model->created_by = Yii::app()->user->id;
    //                $model->updated_by = Yii::app()->user->id;
    //                $model->save();
    //                Yii::app()->user->setFlash('success', 'You have successfully added record.');
    //                $this->redirect(array("sms"));
    //            }
    //        }
    //
    //        $this->render("addSMS", array("model" => $model));
    //    }
    //
    //    /*     * Update SMS */
    //
    //    public function actionUpdateSMS($id) {
    //        $model = $this->loadModel($id, "SmsMaster");
    //
    //        if (isset($_POST["SmsMaster"])) {
    //            $model->attributes = $_POST["SmsMaster"];
    //            $this->performAjaxValidation($model, 'sms-form');
    //
    //            if ($model->validate()) {
    //                $model->updated_dt = common::getTimeStamp();
    //                $model->updated_by = Yii::app()->user->id;
    //                $model->update();
    //                Yii::app()->user->setFlash('success', 'You have successfully updated record.');
    //                $this->redirect(array("sms"));
    //            }
    //        }
    //        $this->render("updateSMS", array("model" => $model));
    //    }
    //
    //    /*     * View SMS sent content */
    //
    //    public function actionViewSMSLog($id) {
    //        $model = $this->loadModel($id, "SmsArchive");
    //        echo $this->renderPartial("_view_emaillog", array("model" => $model));
    //    }
    //
    //    /** Delete SMS Log */
    //    public function actionDeleteSMSLog($id) {
    //        if (Yii::app()->request->isPostRequest) {
    //            // we only allow deletion via POST request
    //            $model = $this->loadModel($id, "SmsArchive");
    //            $model->delete();
    //            echo "<div class=\"alert alert-success\">
    //                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
    //                    You have successfully deleted record.
    //                </div>";
    //            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    //
    //            if (!isset($_GET['ajax']))
    //                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('sms'));
    //        } else
    //            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    //    }
    //
    //    /*     * SMS Log */
    //
    //    public function actionSMSLog() {
    //        $model = new SmsArchive();
    //        if (isset($_GET['SmsArchive'])) {
    //            $model->attributes = $_GET['SmsArchive'];
    //            $model->id = isset($_GET['SmsArchive']['id']) ? $_GET['SmsArchive']['id'] : '';
    //        }
    //        $this->render("SMSLog", array("model" => $model));
    //    }
    //
    //}
    //

<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to 'column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = "mainColumn";
    //public $layoutPath 	  = 'protected/modules/admin/views/layouts/';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $isSuperAdmin, $isCustomer, $isAuthor;

    public function init() {
        if (!Users::model()->isAdminLoggedIn()) {
            $this->redirect(Yii::app()->user->loginUrl);
        }
        if (!Yii::app()->user->isGuest) {
            $this->isSuperAdmin = common::isSuperAdmin();
            $this->isCustomer = common::isCustomer();
            $this->isAuthor = common::isAuthor();
        }
    }

    protected function performAjaxValidation($model, $formId = 'data-form') {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $formId) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function loadModel($id, $modelName) {
        $model = $modelName::model()->findByPk($id);
        if (!empty($model))
            return $model;
        else
            throw new CHttpException(404, common::translateText("404_ERROR"));
    }

    protected function getNextInsertID($modelName) {
        $criteria = new CDbCriteria();
        $criteria->select = "MAX(id) AS id";
        $count = $modelName::model()->find($criteria)->id;
        return !empty($count) ? $count + 1 : 1;
    }

}

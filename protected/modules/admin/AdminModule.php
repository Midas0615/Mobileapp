<?php

class AdminModule extends CWebModule {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'admin.models.*',
            'admin.components.*',
        ));

        Yii::app()->setComponents(array(
            'errorHandler' => array(
                'errorAction' => 'admin/error',
            ),
            'messages' => array(
                //'basePath'=>'application.modules.admin.messages',
                'basePath' => Yiibase::getPathOfAlias('application.modules.admin.messages'),
                'language' => 'en'
            ),
            'user' => array(
                'class' => 'WebUser',
                'stateKeyPrefix' => '_admin',
                'allowAutoLogin' => true,
                'loginUrl' => Yii::app()->createUrl($this->getId() . '/login')
            )
        ));
        $layoutPath = Yii::getPathOfAlias('application.modules.admin.views.layouts');
        // echo "<pre>"; print_r(Yii::app()->components->messages);exit;
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }

}
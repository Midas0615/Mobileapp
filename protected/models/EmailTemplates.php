<?php

/**
 * This is the model class for table "email_templates".
 *
 * The followings are the available columns in table 'email_templates':
 * @property integer $id
 * @property string $email_title
 * @property string $email_subject
 * @property string $email_content
 * @property string $email_from
 * @property string $email_keyword
 * @property integer $deleted
 * @property integer $created_by
 * @property integer $created_dt
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class EmailTemplates extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return EmailTemplates the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'email_templates';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email_title, email_subject, email_content, email_from, email_keyword', 'required'),
            array('email_from', 'email'),
            array('deleted, created_by, created_dt, updated_dt, updated_by', 'numerical', 'integerOnly' => true),
            array('email_title, email_subject, email_from, email_keyword', 'length', 'max' => 128),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, email_title, email_subject, email_content, email_from, email_keyword, deleted, created_by, created_dt, updated_dt, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    public function defaultScope() {

        return array(
            'alias' => $this->getTableAlias(false, false),
            'condition' => "deleted=0 ",
        );
    }

    protected function beforeSave() {
        if ($this->isNewRecord):
            $this->created_dt = common::getTimeStamp();
            $this->created_by = Yii::app()->user->id;
        else:
            $this->updated_dt = common::getTimeStamp();
            $this->updated_by = Yii::app()->user->id;
        endif;
        return parent::beforeSave();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'email_title' => 'Email Title',
            'email_subject' => 'Email Subject',
            'email_content' => 'Email Content',
            'email_from' => 'Email From',
            'email_keyword' => 'Email Keyword',
            'deleted' => 'Deleted',
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
            'updated_dt' => 'Updated Dt',
            'updated_by' => 'Updated By',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('email_title', $this->email_title, true);
        $criteria->compare('email_subject', $this->email_subject, true);
        $criteria->compare('email_content', $this->email_content, true);
        $criteria->compare('email_from', $this->email_from, true);
        $criteria->compare('email_keyword', $this->email_keyword, true);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_dt', $this->created_dt);
        $criteria->compare('updated_dt', $this->updated_dt);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getEmailTemplate($email_keyword) {
        return self::model()->findByAttributes(array("email_keyword" => trim($email_keyword)));
    }

}

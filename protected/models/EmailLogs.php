<?php

/**
 * This is the model class for table "email_logs".
 *
 * The followings are the available columns in table 'email_logs':
 * @property integer $id
 * @property string $email_from
 * @property string $email_to
 * @property string $email_content
 * @property string $email_attachments
 * @property integer $is_email_sent
 * @property integer $created_dt
 * @property integer $created_by
 */
class EmailLogs extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return EmailLogs the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'email_logs';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email_from, email_to, email_content, email_attachments, is_email_sent, created_dt, created_by', 'required'),
            array('is_email_sent, created_dt, created_by', 'numerical', 'integerOnly' => true),
            array('email_from, email_to', 'length', 'max' => 128),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, email_from, email_to, email_content, email_attachments, is_email_sent, created_dt, created_by', 'safe', 'on' => 'search'),
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
            'email_from' => 'Email From',
            'email_to' => 'Email To',
            'email_content' => 'Email Content',
            'email_attachments' => 'Email Attachments',
            'is_email_sent' => 'Is Email Sent',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
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
        $criteria->compare('email_from', $this->email_from, true);
        $criteria->compare('email_to', $this->email_to, true);
        $criteria->compare('email_content', $this->email_content, true);
        $criteria->compare('email_attachments', $this->email_attachments, true);
        $criteria->compare('is_email_sent', $this->is_email_sent);
        $criteria->compare('created_dt', $this->created_dt);
        $criteria->compare('created_by', $this->created_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id DESC'
            )
        ));
    }

}

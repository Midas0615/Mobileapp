<?php

/**
 * This is the model class for table "vendor".
 *
 * The followings are the available columns in table 'vendor':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $location
 * @property integer $is_deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 * @property integer $ip_address
 */
class Vendor extends CActiveRecord {

    const DE_ACTIVE = 0;
    const Active = 1;

    public $statusArr = array(self::Active => "Active", self::DE_ACTIVE => "Deactive");

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Vendor the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'mob_vendor';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('status, is_deleted, created_dt, created_by, updated_dt, updated_by, ip_address', 'numerical', 'integerOnly' => true),
            array('name,description, location', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, description,  location,status, is_deleted, created_dt, created_by, updated_dt, updated_by, ip_address', 'safe', 'on' => 'search'),
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
            'condition' => "t.is_deleted=0 ",
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
            'name' => 'Vendor Name',
            'description' => 'Sort Description',
            'location' => 'Location',
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

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.location', $this->location, true);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('t.is_deleted', $this->is_deleted);
        $criteria->compare('t.created_dt', $this->created_dt);
        $criteria->compare('t.created_by', $this->created_by);
        $criteria->compare('t.updated_dt', $this->updated_dt);
        $criteria->compare('t.updated_by', $this->updated_by);
        $criteria->compare('t.ip_address', $this->ip_address);
        if ($this->id) {
            $criteria->compare('t.name', $this->id,true,'OR');
            $criteria->compare('t.description', $this->id,true,'OR');
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params->defaultPageSize
            )
        ));
    }

    public function getAllVendorList() {
        $criteria = new CDbCriteria;
        $criteria->compare('status', self::Active);
        return CHtml::ListData($this->findAll($criteria), "id", "name");
    }

}

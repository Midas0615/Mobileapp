<?php

/**
 * This is the model class for table "users_group".
 *
 * The followings are the available columns in table 'users_group':
 * @property integer $id
 * @property string $group_name
 * @property integer $deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class UsersGroup extends CActiveRecord {

    const SUPER_ADMIN = 1;
    const ADMIN = 2;
    const CUSTOMER = 3;
    const AUTHOR = 4;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UsersGroup the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function defaultScope() {
        $condition = (!Yii::app()->user->isSuperAdmin()) ? " AND id != '" . self::SUPER_ADMIN . "' " : "";
        return array(
            'alias' => $this->getTableAlias(false, false),
            'condition' => "deleted=0 " . $condition,
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
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{users_group}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('group_name', 'required'),
            array('group_name', 'unique'),
            array('deleted, created_dt, created_by, updated_dt, updated_by', 'numerical', 'integerOnly' => true),
            array('group_name', 'length', 'max' => 20),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, group_name, deleted, created_dt, created_by, updated_dt, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            "permissionsRel" => array(self::HAS_MANY, "GroupRights", "group_id", "joinType" => "LEFT JOIN")
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'group_name' => 'Group Name',
            'deleted' => 'Deleted',
            'created_dt' => 'Created Date',
            'created_by' => 'Created By',
            'updated_dt' => 'Updated Date',
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
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => Yii::app()->params->defaultPageSize)
        ));
    }

    public function getUsersGroup() {
        return UsersGroup::model()->findAll();
    }

}

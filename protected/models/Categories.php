<?php

/**
 * This is the model class for table "categories".
 *
 * The followings are the available columns in table 'categories':
 * @property string $id
 * @property string $title
 * @property string $parent_id
 * @property string $description
 * @property integer $deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class Categories extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Categories the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'categories';
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
            unset($this->created_dt);
            $this->updated_dt = common::getTimeStamp();
            $this->updated_by = Yii::app()->user->id;
        endif;
        return parent::beforeSave();
    }

    protected function afterFind() {
        $this->created_dt = (!empty($this->created_dt) && common::isNumeric($this->created_dt)) ? common::getDateTimeFromTimeStamp($this->created_dt, Yii::app()->params->dateTimeFormatPHP) : "";
        $this->updated_dt = (!empty($this->updated_dt) && common::isNumeric($this->updated_dt)) ? common::getDateTimeFromTimeStamp($this->updated_dt, Yii::app()->params->dateTimeFormatPHP) : "";
        return parent::afterFind();
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'required'),
            array('title', 'unique'),
            array('deleted, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('parent_id', 'length', 'max' => 20),
            array('description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, parent_id, description, deleted, created_dt, created_by, updated_dt, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            //"parentRel" => array(self::BELONGS_TO, 'Categories', 'parent_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'parent_id' => 'Parent',
            'description' => 'Description',
            'deleted' => 'Deleted',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('parent_id', $this->parent_id, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('created_dt', $this->created_dt);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_dt', $this->updated_dt);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'parent_id',
                ),
                'defaultOrder' => 'parent_id ASC, title ASC',
            ),
            'pagination' => array(
                'pageSize' => Yii::app()->params->defaultPageSize
            )
        ));
    }

    public function getParentCategoriesList() {
        return CHtml::ListData($this->findAllByAttributes(array("parent_id" => 0)), "id", "title");
    }

}

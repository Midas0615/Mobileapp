<?php

/**
 * This is the model class for table "mob_rating".
 *
 * The followings are the available columns in table 'mob_rating':
 * @property integer $id
 * @property string $name
 * @property integer $star
 * @property integer $product_id
 * @property integer $order_id
 * @property integer $created_by
 * @property integer $created_dt
 * @property integer $updated_by
 * @property integer $updated_dt
 * @property integer $is_deleted
 */
class FavoriteProduct extends CActiveRecord {

    public $starcount;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Rating the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'mob_favorite_product';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, product_id,  created_by, created_dt, updated_by, updated_dt, is_deleted', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id,  user_id, product_id,  created_by, created_dt, updated_by, updated_dt, is_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'users' => array(self::BELONGS_TO, "Users", "user_id"),
            'product' => array(self::BELONGS_TO, "Product", "product_id"),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'product_id' => 'Product',
            'user_id' => 'User',
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
            'updated_by' => 'Updated By',
            'updated_dt' => 'Updated Date',
            'is_deleted' => 'Is Deleted',
        );
    }

    public function defaultScope() {
        $alias = $this->getTableAlias(false, false);
        if ($alias == '' || $alias == 't') {
            return array('condition' => "t.is_deleted=  0 ",);
        } else {
            return array('condition' => $alias . ".is_deleted= 0 ",);
        }
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
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.product_id', $this->product_id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.created_by', $this->created_by);
        $criteria->compare('t.created_dt', $this->created_dt);
        $criteria->compare('t.updated_by', $this->updated_by);
        $criteria->compare('t.updated_dt', $this->updated_dt);
        $criteria->compare('t.is_deleted', $this->is_deleted);

        $criteria->with = array('product');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    public function getProductlistonuser() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 'GROUP_CONCAT(t.id) as id';
        $criteria->compare('t.user_id', Yii::app()->user->id);
        $model = self::model()->findAll($criteria);
        return $model->id;
    }

}

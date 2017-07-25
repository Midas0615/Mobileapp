<?php

/**
 * This is the model class for table "mob_comments".
 *
 * The followings are the available columns in table 'mob_comments':
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $product_id
 * @property string $comments
 * @property integer $order_id
 * @property integer $created_by
 * @property integer $created_dt
 * @property integer $updated_by
 * @property integer $updated_dt
 * @property integer $is_deleted
 */
class Review extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Review the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{review}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id,comments', 'required'),
            array('user_id, product_id, order_id, created_by, created_dt, updated_by, updated_dt, is_deleted', 'numerical', 'integerOnly' => true),
            array('comments,name', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id,name, user_id, product_id, comments, order_id, created_by, created_dt, updated_by, updated_dt, is_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            //'users' => array(self::BELONGS_TO, "Users", "user_id"),
            'product' => array(self::BELONGS_TO, "Product", "product_id"),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'product_id' => 'Product',
            'comments' => 'Comments',
            'order_id' => 'Order',
            'created_by' => 'Created By',
            'created_dt' => 'Created Date',
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
            $this->created_by = (isset(Yii::app()->user->id)) ? Yii::app()->user->id : 1;
        else:
            $this->updated_dt = common::getTimeStamp();
            $this->updated_by = (isset(Yii::app()->user->id)) ? Yii::app()->user->id : 1;
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
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.product_id', $this->product_id);
        $criteria->compare('t.comments', $this->comments, true);
        $criteria->compare('t.order_id', $this->order_id);
        $criteria->compare('t.created_by', $this->created_by);
        $criteria->compare('t.created_dt', $this->created_dt);
        $criteria->compare('t.updated_by', $this->updated_by);
        $criteria->compare('t.updated_dt', $this->updated_dt);
        $criteria->compare('t.is_deleted', $this->is_deleted);
        if ($this->id) {
            $criteria->compare('t.created_dt', common::getTimeStamp($this->id, "d/m/Y"), false, 'OR');
            $criteria->compare('t.comments', $this->id, true, 'OR');
            //$criteria->compare('t.status', array_search($this->id, self::model()->statusArr), true, 'OR');
            $criteria->compare('product.title', $this->id, true, 'OR');
        }
        $criteria->with = array('product');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

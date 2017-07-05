<?php

/**
 * This is the model class for table "mob_comments".
 *
 * The followings are the available columns in table 'mob_comments':
 * @property integer $id
 * @property integer $user_id
 * @property integer $product_id
 * @property string $comments
 * @property integer $order_id
 * @property integer $created_by
 * @property integer $created_dt
 * @property integer $updated_by
 * @property integer $updated_date
 * @property integer $is_deleted
 */
class Comments extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Comments the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'mob_comments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, product_id, order_id, created_by, created_dt, updated_by, updated_date, is_deleted', 'numerical', 'integerOnly' => true),
            array('comments', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, product_id, comments, order_id, created_by, created_dt, updated_by, updated_date, is_deleted', 'safe', 'on' => 'search'),
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
            'created_dt' => 'Created Dt',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'is_deleted' => 'Is Deleted',
        );
    }

    public function defaultScope() {
        return array(
            'alias' => $this->getTableAlias(false, false),
            'condition' => "is_deleted=0 ",
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
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('comments', $this->comments, true);
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_dt', $this->created_dt);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_date', $this->updated_date);
        $criteria->compare('is_deleted', $this->is_deleted);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

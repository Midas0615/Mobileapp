<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property integer $user_id 
 * @property integer $product_id
 * @property integer $qty
 * @property string $address
 * @property integer $order_amount
 * @property integer $order_date
 * @property integer $status
 * @property string $summary
 * @property integer $is_deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 * @property integer $ip_address
 */
class Order extends CActiveRecord {

    const NEW_ORDER = 1;
    const RECEIVED = 2;
    const OUT_OF_DELIVERY = 3;
    const COMPLETED = 4;

    public $statusArr = array(self::NEW_ORDER => "New", self::RECEIVED => "Received", self::OUT_OF_DELIVERY => "Out Of Delivery", self::COMPLETED => "Completed");

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Order the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{order}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id,product_id,address,order_amount', 'required'),
            array('status,order_date,qty, is_deleted, created_dt, created_by, updated_dt, updated_by, ip_address', 'numerical', 'integerOnly' => true),
            array('summary', 'length', 'max' => 50000),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id,summary,order_amount,order_date,address,qty,user_id,product_id,status, is_deleted, created_dt, created_by, updated_dt, updated_by, ip_address', 'safe', 'on' => 'search'),
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
            'product_id' => 'Product',
            'qty' => 'Quantity',
            'address' => 'Address',
            'order_amount' => 'Order Amount',
            'summary' => 'Order Summery',
            'order_date' => 'Order Date',
            'status' => 'Status',
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
        $criteria->compare('t.product_id', $this->product_id, true);
        $criteria->compare('t.user_id', $this->user_id, true);
        $criteria->compare('t.qty', $this->qty, true);
        $criteria->compare('t.address', $this->address, true);
        $criteria->compare('t.order_amount', $this->order_amount);
        $criteria->compare('t.summary', $this->summary);
        $criteria->compare('t.order_date', $this->order_date, true);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('t.is_deleted', $this->is_deleted);
        $criteria->compare('t.created_dt', $this->created_dt);
        $criteria->compare('t.created_by', $this->created_by);
        $criteria->compare('t.updated_dt', $this->updated_dt);
        $criteria->compare('t.updated_by', $this->updated_by);
        $criteria->compare('t.ip_address', $this->ip_address);

        if ($this->id) {
            $criteria->compare('t.qty', $this->id, true,'OR');
            $criteria->compare('t.address', $this->id, true,'OR');
            $criteria->compare('t.order_amount', $this->id,true,'OR');
            $criteria->compare('t.summary', $this->id,true,'OR');
            $criteria->compare('t.order_date', common::getTimeStamp($this->id,"d/m/Y"),true,'OR');
            $criteria->compare('t.status', array_search ($this->id, self::model()->statusArr),true,'OR');
            $criteria->compare('users.first_name', $this->id,true,'OR');
            $criteria->compare('users.last_name', $this->id,true,'OR');
            $criteria->compare('product.title', $this->id,true,'OR');
        }
        $criteria->with = array( 'users','product' );
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params->defaultPageSize
            )
            
        ));
    }
    public function countByField($field = false, $value = false, $user_id = null) {
        $criteria = new CDbCriteria();
        if (isset($field) && isset($value)):
            $criteria->compare($field, $value);
        endif;
        return $this->count($criteria);
    }

}

<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $long_description
 * @property string $photo
 * @property integer $price
 * @property integer $vendor
 * @property string $location
 * @property integer $is_deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 * @property integer $ip_address
 */
class Product extends CActiveRecord {

    const THUMB_SMALL = "small_";
    const THUMB_HEIGHT = "600";
    const THUMB_WIDTH = "600";

    public $thumbArr = array(self::THUMB_WIDTH, self::THUMB_HEIGHT); //width,height
    public $search;

    const DE_ACTIVE = 0;
    const Active = 1;
    const OUT_OF_STOCK = 2;

    public $statusArr = array(self::Active => "Active", self::DE_ACTIVE => "Deactive", self::OUT_OF_STOCK => "Out Of Stock");
    public $vendorArr = array(self::Active => "Vandor A", self::DE_ACTIVE => "Vander B", self::OUT_OF_STOCK => "Vandor C");

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{product}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, description', 'required'),
            array('price, vendor,status, is_deleted, created_dt, created_by, updated_dt, updated_by, ip_address', 'numerical', 'integerOnly' => true),
            array('title, photo, location', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, description, long_description, photo, price, vendor, location,status, is_deleted, created_dt, created_by, updated_dt, updated_by, ip_address', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'vendorRel' => array(self::BELONGS_TO, "Vendor", "vendor"),
            'reviewRel' => array(self::HAS_MANY, 'Review', 'product_id'),
        );
    }

    public function defaultScope() {
        $alias = $this->getTableAlias(false, false);
        if ($alias == '' || $alias == 't') {
            return array('condition' => "t.deleted=  0 ",);
        } else {
            return array('condition' => $alias . ".deleted= 0 ",);
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
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Product Title',
            'description' => 'Sort Description',
            'long_description' => 'Long Description',
            'photo' => 'Image',
            'price' => 'Price',
            'vendor' => 'Vendor',
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
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.long_description', $this->long_description, true);
        $criteria->compare('t.photo', $this->photo, true);
        $criteria->compare('t.price', $this->price);
        $criteria->compare('t.vendor', $this->vendor);
        $criteria->compare('t.location', $this->location, true);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('t.is_deleted', $this->is_deleted);
        $criteria->compare('t.created_dt', $this->created_dt);
        $criteria->compare('t.created_by', $this->created_by);
        $criteria->compare('t.updated_dt', $this->updated_dt);
        $criteria->compare('t.updated_by', $this->updated_by);
        $criteria->compare('t.ip_address', $this->ip_address);
        if ($this->id) {
            $criteria->compare('t.id', $this->id, false, 'OR');
            $criteria->compare('t.title', $this->id, true, 'OR');
            $criteria->compare('t.description', $this->id, true, 'OR');
            $criteria->compare('t.long_description', $this->id, true, 'OR');
            $criteria->compare('t.photo', $this->id, true, 'OR');
            $criteria->compare('t.price', $this->id, false, 'OR');
            $criteria->compare('t.status', array_search($this->id, self::model()->statusArr), true, 'OR');
            $criteria->compare('vendorRel.name', $this->id, true, 'OR');
            $criteria->compare('t.location', $this->id, true, 'OR');
        }
        $criteria->with = array('vendorRel', 'reviewRel');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params->defaultPageSize
            )
        ));
    }

    public function uploadImage($model) {
        $image = CUploadedFile::getInstance($model, 'photo');
        $directoryPath = Yii::app()->params->paths['productPath'] . $model->id . "/";
        if (common::checkAndCreateDirectory($directoryPath) && !empty($image)) {
            $image->saveAs($directoryPath . $image->getName());
            $origionalPath = $directoryPath . $image->getName();
            $thumbProfilePic = self::THUMB_SMALL . $image->getName();
            $thumbPath = $directoryPath . $thumbProfilePic;
            $image = Yii::app()->image->load($origionalPath);
            $profilePicThumbArr = $this->thumbArr;
            $image->resize($profilePicThumbArr[0], $profilePicThumbArr[1]);
            $image->save($thumbPath);
            return $thumbProfilePic;
        } else {
            return $model->photo;
        }
    }

    function getImage($image = null, $id = null) {
        $uploadPath = Yii::app()->params->paths['productPath'] . $id . "/";
        if (file_exists($uploadPath . $image)) {
            return Yii::app()->params->paths['productURL'] . $id . "/" . $image;
        } else {
            return Yii::app()->params->ADMIN_BT_URL . "image/avatar/avatar.png";
        }
    }

    public function getAllProductList() {
        $criteria = new CDbCriteria;
        $criteria->compare('status', self::Active);
        return CHtml::ListData($this->findAll($criteria), "id", "title");
    }

    public function countByField($field = false, $value = false, $user_id = null) {
        $criteria = new CDbCriteria();
        if (isset($field) && isset($value)):
            $criteria->compare($field, $value);
        endif;
        return $this->count($criteria);
    }

}

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
    const THUMB_SMALL = "small_";
    const THUMB_HEIGHT = "600";
    const THUMB_WIDTH = "600";

    public $thumbArr = array(self::THUMB_WIDTH, self::THUMB_HEIGHT); //width,height
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
        return '{{vendor}}';
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
            array('name,description, location ,photo,image_path', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id,image_path,photo name, description,  location,status, is_deleted, created_dt, created_by, updated_dt, updated_by, ip_address', 'safe', 'on' => 'search'),
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
        $alias = $this->getTableAlias(false, false);
        if ($alias == '' || $alias == 't') {
            return array('condition' => "t.is_deleted=  0 ",);
        } else {
            return array('condition' => $alias . ".is_deleted= 0 ",);
        }
    }

    public function afterFind() {
        $this->image_path = Yii::app()->params['paths']['vendorURL'] . $this->id . '/' . $this->photo;
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
    public function uploadImage($model) {
        $image = CUploadedFile::getInstance($model, 'photo');
        $directoryPath = Yii::app()->params->paths['vendorPath'] . $model->id . "/";
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
        $uploadPath = Yii::app()->params->paths['vendorPath'] . $id . "/";
        if (file_exists($uploadPath . $image)) {
            return Yii::app()->params->paths['vendorURL'] . $id . "/" . $image;
        } else {
            return Yii::app()->params->ADMIN_BT_URL . "image/avatar/avatar.png";
        }
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Vendor Name',
            'description' => 'Short Description',
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
            $criteria->compare('t.name', $this->id, false, 'OR');
            $criteria->compare('t.description', $this->id, false, 'OR');
            $criteria->compare('t.status', array_search($this->id, self::model()->statusArr), true, 'OR');
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

    public function countByField($field = false, $value = false, $user_id = null) {
        $criteria = new CDbCriteria();
        if (isset($field) && isset($value)):
            $criteria->compare($field, $value);
        endif;
        return $this->count($criteria);
    }

}

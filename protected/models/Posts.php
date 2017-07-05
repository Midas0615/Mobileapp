<?php

/**
 * This is the model class for table "posts".
 *
 * The followings are the available columns in table 'posts':
 * @property string $id
 * @property string $title
 * @property string $category_id
 * @property string $image
 * @property string $description
 * @property integer $deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class Posts extends CActiveRecord {

    const THUMB_SMALL = "small_";
    const THUMB_HEIGHT = "600";
    const THUMB_WIDTH = "600";

    public $thumbArr = array(self::THUMB_WIDTH, self::THUMB_HEIGHT); //width,height

    const DRAFT = 4;
    const PUBLISHED = 1;
    const PENDING_FOR_APPROVAL = 2;
    const DISABLED = 3;

    public $statusArr = array(self::DRAFT => "Draft", self::PENDING_FOR_APPROVAL => "Ask For Approval", self::PUBLISHED => "Published", self::DISABLED => "Disabled");

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Posts the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'mob_posts';
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
        $this->start_date = !empty($this->start_date) ? common::getTimeStamp($this->start_date) : "";
        $this->end_date = !empty($this->end_date) ? common::getTimeStamp($this->end_date) : "";
        return parent::beforeSave();
    }

    protected function afterFind() {
        $this->created_dt = (!empty($this->created_dt) && common::isNumeric($this->created_dt)) ? common::getDateTimeFromTimeStamp($this->created_dt, Yii::app()->params->dateTimeFormatPHP) : "";
        $this->updated_dt = (!empty($this->updated_dt) && common::isNumeric($this->updated_dt)) ? common::getDateTimeFromTimeStamp($this->updated_dt, Yii::app()->params->dateTimeFormatPHP) : "";
        $this->start_date = (!empty($this->start_date) && common::isNumeric($this->start_date)) ? common::getDateTimeFromTimeStamp($this->start_date, Yii::app()->params->dateFormatPHP) : "";
        $this->end_date = (!empty($this->end_date) && common::isNumeric($this->end_date)) ? common::getDateTimeFromTimeStamp($this->end_date, Yii::app()->params->dateFormatPHP) : "";
        return parent::afterFind();
    }

    protected function beforeFind() {
        if (common::isAuthor()) {
            $criteria = new CDbCriteria;
            $criteria->compare("author_id", Yii::app()->user->id);
            $this->dbCriteria->mergeWith($criteria);
        }
        return parent::beforeFind();
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title,author_id,category_id,description', 'required'),
            array('image', 'file', 'allowEmpty' => true, 'types' => implode(",", Yii::app()->params->allowedImages)),
            array("link", "url"),
            array('deleted, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('title, category_id, image', 'length', 'max' => 255),
            array('description,status,author_id,link,start_date,end_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, category_id, image, description, deleted, created_dt, created_by, updated_dt, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'categoryRel' => array(self::BELONGS_TO, "Categories", "category_id"),
            'authorRel' => array(self::BELONGS_TO, "Users", "author_id"),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'category_id' => 'Category',
            'author_id' => 'Author',
            'image' => 'Photo',
            'description' => 'Description',
            'deleted' => 'Deleted',
            'created_dt' => 'Posted Date',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('created_dt', $this->created_dt);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_dt', $this->updated_dt);
        $criteria->compare('updated_by', $this->updated_by);
        if (common::isAuthor()) {
            $criteria->compare("author_id", Yii::app()->user->id);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params->defaultPageSize
            )
        ));
    }

    public function uploadImage($model) {
        $image = CUploadedFile::getInstance($model, 'image');
        $directoryPath = Yii::app()->params->paths['postsPath'] . $model->id . "/";
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
            return $model->image;
        }
    }

    function getImage($image = null, $id = null) {
        $uploadPath = Yii::app()->params->paths['postsPath'] . $id . "/";
        if (file_exists($uploadPath . $image)) {
            return Yii::app()->params->paths['postsURL'] . $id . "/" . $image;
        } else {
            return Yii::app()->params->ADMIN_BT_URL . "image/avatar/avatar.png";
        }
    }

    public function countPostByField($field = false, $value = false, $user_id = null) {
        $criteria = new CDbCriteria();
        if (isset($field) && isset($value)):
            $criteria->compare($field, $value);
        endif;
        $criteria->compare("author_id", $user_id);
        return $this->count($criteria);
    }

}

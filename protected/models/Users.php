<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $repeat_password
 * @property string $salt
 * @property string $email_address
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $phone_number
 * @property integer $gender
 * @property integer $birth_date
 * @property string $address
 * @property integer $country_id
 * @property integer $state_id
 * @property string $city
 * @property integer $zipcode
 * @property string $profile_pic
 * @property integer $user_group
 * @property integer $status
 * @property integer $deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class Users extends CActiveRecord {

    const ACTIVE = 1;
    const IN_ACTIVE = 2;
    const MALE = 1;
    const FE_MALE = 0;
    const THUMB_SMALL = "small_";
    const NOT_VERIFIED = 1;
    const VERIFIED = 2;

    public $statusArr = array(self::ACTIVE => "Active", self::IN_ACTIVE => "In Active");
    public $genderArr = array(self::MALE => "Male", self::FE_MALE => "Female");

    const THUMB_HEIGHT = "100";
    const THUMB_WIDTH = "100";
    const MY_ADMIN = 1;

    public $profilePicThumbArr = array(self::THUMB_WIDTH, self::THUMB_HEIGHT); //width,height
    public $repeat_password, $full_name, $access_token, $last_login, $is_verified;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /* Default scope whilefetching results      */

    public function defaultScope() {
        $alias = $this->getTableAlias(false, false);
        if ($alias == '' || $alias == 't') {
            return array('condition' => "t.deleted=0 AND t.id != '" . self::MY_ADMIN . "' ",);
        } else {
            return array('condition' => $alias . ".deleted=0  AND " . $alias . ".id != '" . self::MY_ADMIN . "' ",);
        }
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'mob_users';
    }

    protected function beforeSave() {
        if ($this->isNewRecord):
            $this->salt = $this->generateSalt();
            $this->password = $this->hashPassword($this->password, $this->salt);
            $this->repeat_password = $this->password;
            $this->created_dt = common::getTimeStamp();
            $this->created_by = Yii::app()->user->id;
        else:
            unset($this->created_dt);
            $this->last_login = (!common::isNumeric($this->last_login)) ? common::getTimeStamp($this->last_login) : $this->last_login;
            $this->updated_dt = common::getTimeStamp();
            $this->updated_by = Yii::app()->user->id;
        endif;
        return parent::beforeSave();
    }

    protected function afterFind() {
        $this->full_name = $this->first_name . " " . $this->last_name;
        $this->birth_date = !empty($this->birth_date) ? common::getDateTimeFromTimeStamp($this->birth_date, Yii::app()->params->dateFormatPHP) : "";
        $this->last_login = !empty($this->last_login) ? common::getDateTimeFromTimeStamp($this->last_login, Yii::app()->params->dateTimeFormatPHP) : "";
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
            array("email_address", "required", "on" => "forgot_password"),
            array("email_address", "checkEmailExists", "on" => "forgot_password"),
            array("email_address,first_name,last_name,password,repeat_password,phone_number", "required", "on" => "signup"),
            array('repeat_password', 'compare', 'compareAttribute' => 'password', 'on' => 'signup'),
            array('username,email_address, first_name, last_name,user_group', 'required'),
            array("username,email_address", "unique", "on" => "signup"),
            array("username,email_address", "unique", "on" => "add"),
            array("email_address", "email"),
            array('password,repeat_password', 'required', 'on' => 'add'),
            array('profile_pic', 'file', 'allowEmpty' => true, 'types' => implode(",", Yii::app()->params->allowedImages)),
            array('repeat_password', 'compare', 'compareAttribute' => 'password', 'on' => 'add'),
            array('password,repeat_password', 'required', 'on' => 'change_password'),
            array('repeat_password', 'compare', 'compareAttribute' => 'password', 'on' => 'change_password'),
            array('gender, country_id, state_id, zipcode, user_group, status, deleted, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('username, first_name, middle_name, last_name', 'length', 'max' => 50),
            array('password, salt', 'length', 'max' => 255),
            array('email_address, city', 'length', 'max' => 100),
            array('phone_number', 'length', 'max' => 20),
            array('profile_pic', 'length', 'max' => 128),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, password, repeat_password,salt, email_address, first_name, middle_name, last_name, phone_number, gender, birth_date, address, country_id, state_id, city, zipcode, profile_pic, user_group, status, deleted, created_dt, created_by, updated_dt, updated_by', 'safe', 'on' => 'search'),
        );
    }

    public function checkEmailExists() {
        if (!empty($this->email_address)) {
            $model = self::model()->findByAttributes(array("email_address" => $this->email_address));
            if (empty($model)) {
                $this->addError("email_address", "Provided email address isnot available in our records.");
            }
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            "usersGroupRel" => array(self::BELONGS_TO, "UsersGroup", "user_group"),
            'countryRel' => array(self::BELONGS_TO, "Countries", "country_id"),
            'stateRel' => array(self::BELONGS_TO, "States", "state_id"),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'repeat_password' => 'Repeat Password',
            'salt' => 'Salt',
            'email_address' => 'Email',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'phone_number' => 'Mobile No.',
            'gender' => 'Gender',
            'birth_date' => 'Birth Date',
            'address' => 'Address',
            'country_id' => 'Country',
            'state_id' => 'State',
            'city' => 'City',
            'zipcode' => 'Zipcode',
            'profile_pic' => 'Profile Pic',
            'user_group' => 'User Type',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_dt' => 'Member Since',
            'created_by' => 'Created By',
            'updated_dt' => 'Last Updated Date',
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

        $searchArr = explode(",", $this->id);
        foreach ($searchArr as $search) {
            $criteria->compare("CONCAT(t.first_name,' ',t.last_name)", $search, true, "OR");
            $criteria->compare("t.phone_number", $search, true, "OR");
            $criteria->compare("t.email_address", $search, true, "OR");
            $criteria->compare("t.address", $search, true, "OR");
            $criteria->compare("countryRel.country", $search, true, "OR");
            $criteria->compare("stateRel.name", $search, true, "OR");
        }
        $criteria->with = array("countryRel", "stateRel");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id ASC',
            ),
            'pagination' => array(
                'pageSize' => Yii::app()->params->defaultPageSize
            )
        ));
    }

    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword($password) {
        return $this->hashPassword($password, $this->salt) === $this->password;
    }

    /**
     * Generates the password hash.
     * @param string password
     * @param string salt
     * @return string hash
     */
    public function hashPassword($password, $salt) {
        return md5($salt . $password);
    }

    /**
     * Generates a salt that can be used to generate a password hash.
     * @return string the salt
     */
    public function generateSalt() {
        return uniqid('', true);
    }

    /* Function for check admin is logged or not */

    public function isAdminLoggedIn() {
        Yii::app()->user->loadWebUser();
        return (isset($_SESSION["is_backend_login"]) && !empty(Yii::app()->user->id)) ? true : false;
    }

    public function isLoggedIn() {
        Yii::app()->user->loadWebUser();
        return (isset($_SESSION["is_front_login"]) && !empty(Yii::app()->user->id)) ? true : false;
    }

    /* Function For upload profile picture with thumb */

    public function uploadProfilePicture($model) {
        $profile_pic = CUploadedFile::getInstance($model, 'profile_pic');
        $directoryPath = Yii::app()->params->paths['usersPath'] . $model->id . "/";
        if (common::checkAndCreateDirectory($directoryPath) && !empty($profile_pic)) {
            $profile_pic->saveAs($directoryPath . $profile_pic->getName());
            $origionalPath = $directoryPath . $profile_pic->getName();
            $thumbProfilePic = Users::THUMB_SMALL . $profile_pic->getName();
            $thumbPath = $directoryPath . $thumbProfilePic;
            $image = Yii::app()->image->load($origionalPath);
            $profilePicThumbArr = Users::model()->profilePicThumbArr;
            $image->resize($profilePicThumbArr[0], $profilePicThumbArr[1]);
            $image->save($thumbPath);
            return $thumbProfilePic;
        } else {
            return $model->profile_pic;
        }
    }

    public function getAddressFormat($model) {
        $address = !empty($model->address) ? $model->address . "\n" : "";
        $country = !empty($model->countryRel->country) ? $model->countryRel->country . "\n" : "";
        $state = !empty($model->stateRel->name) ? $model->stateRel->name . "\n" : "";
        $city = !empty($model->city) ? $model->city . "\n" : "";
        return $address . $city . $state . $country;
    }

    public function getAuthorList() {
        $criteria = new CDbCriteria();
        $criteria->compare("t.user_group", UsersGroup::AUTHOR);
        return CHtml::ListData($this->findAll($criteria), "id", "full_name");
    }

    public function getAllUserList() {
        return CHtml::ListData($this->findAll(), "id", "full_name");
    }

    public function countUserByField($field = false, $value = false) {
        $criteria = new CDbCriteria();
        if (isset($field) && isset($value)):
            $criteria->compare($field, $value);
        endif;
        $criteria->compare("user_group", UsersGroup::CUSTOMER);
        return $this->count($criteria);
    }

    public function countAuthorByField($field = false, $value = false) {
        $criteria = new CDbCriteria();
        if (isset($field) && isset($value)):
            $criteria->compare($field, $value);
        endif;
        $criteria->compare("user_group", UsersGroup::AUTHOR);
        return $this->count($criteria);
    }

    public function countByField($field = false, $value = false, $user_id = null) {
        $criteria = new CDbCriteria();
        if (isset($field) && isset($value)):
            $criteria->compare($field, $value);
        endif;
        return $this->count($criteria);
    }

}

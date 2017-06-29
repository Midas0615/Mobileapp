<?php

/**
 * This is the model class for table "states".
 *
 * The followings are the available columns in table 'states':
 * @property string $id
 * @property string $region_id
 * @property string $name
 * @property string $timezone
 *
 * The followings are the available model relations:
 * @property Countries $region
 */
class States extends CActiveRecord {
    
    const DEFAULT_STATE = "1309";

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return States the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'states';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('region_id', 'length', 'max' => 10),
            array('name, timezone', 'length', 'max' => 45),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, region_id, name, timezone', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'region' => array(self::BELONGS_TO, 'Countries', 'region_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'region_id' => 'Region',
            'name' => 'Name',
            'timezone' => 'Timezone',
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
        $criteria->compare('region_id', $this->region_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('timezone', $this->timezone, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    public function getStates($country_id){
        return States::model()->findAll("region_id=:region_id",array(":region_id"=>$country_id));
    }
}

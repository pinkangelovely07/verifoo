<?php

/**
 * This is the model class for table "business".
 *
 * The followings are the available columns in table 'business':
 * @property string $id
 * @property string $user_id
 * @property string $businessname
 * @property string $description
 * @property string $address
 * @property string $views
 * @property string $category
 * @property string $zipcode
 * @property integer $dti_verified
 * @property string $logo
 * @property string $slug
 * @property string $datecreated
 */
class Business extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'business';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, businessname, views, zipcode, address, dti_verified, datecreated', 'required'),
			array('dti_verified', 'numerical', 'integerOnly'=>true),
			array('user_id, views', 'length', 'max'=>20),
			array('businessname', 'length', 'max'=>50),
			array('category, slug, address', 'length', 'max'=>255),
			array('zipcode', 'length', 'max'=>10),
			array('logo', 'length', 'max'=>100),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, businessname, description, address, views, category, zipcode, dti_verified, logo, slug, datecreated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'businessprofile' => array(self::HAS_ONE, 'Businessprofile', 'business_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'businessname' => 'Businessname',
			'description' => 'Description',
			'address' => 'Address',
			'views' => 'Views',
			'category' => 'Category',
			'zipcode' => 'Zipcode',
			'dti_verified' => 'DTI Verified',
			'logo' => 'Logo',
			'slug' => 'Slug',
			'datecreated' => 'Date Created',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('businessname',$this->businessname,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('views',$this->views,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('zipcode',$this->zipcode,true);
		$criteria->compare('dti_verified',$this->dti_verified);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('datecreated',$this->datecreated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Business the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

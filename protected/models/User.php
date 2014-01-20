<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $user_id
 * @property string $email
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_num
 * @property string $city
 * @property string $zip_code
 * @property string $address
 * @property string $user_status
 * @property string $password
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, username, first_name, last_name, phone_num, city, zip_code, address, password', 'required'),
                        array('email', 'email', 'allowEmpty'=>false),
                        array('email', 'unique', 'className' => 'User','message' => Yii::t('user','already_been_used')),
			array('username', 'length', 'max'=>55),
                        array('username', 'unique', 'className' => 'User','message' => Yii::t('user','already_been_used')),
			array('first_name, last_name', 'length', 'max'=>60),
			array('phone_num', 'length', 'max'=>12),
			array('city, password', 'length', 'max'=>45),
			array('zip_code', 'length', 'max'=>4),
                        array('zip_code', 'numerical', 'min'=>1000, 'max'=>9999),
                        array('phone_num', 'match', 'pattern' => '#^[0-9\\+]{7,12}$#'),
                        array('last_name', 'match', 'pattern' => '#^[a-zA-Z ÀÁÂÃÄĀĂÈÉÊËĚĔĒÌÍÎÏĪĨĬÒÓÔÕÖŐŌÙÚÛÜŪŬŨŰàáâãäāăèéêëēěĕìíîïīĩĭòóôõöőōŏùúûüūŭũű]{1,60}$#', 'allowEmpty'=>false),
                        array('first_name', 'match', 'pattern' => '#^[a-zA-Z ÀÁÂÃÄĀĂÈÉÊËĚĔĒÌÍÎÏĪĨĬÒÓÔÕÖŐŌÙÚÛÜŪŬŨŰàáâãäāăèéêëēěĕìíîïīĩĭòóôõöőōŏùúûüūŭũű]{1,60}$#', 'allowEmpty'=>false),
                        array('username', 'match', 'pattern' => '#^[0-9a-zA-Z ÀÁÂÃÄĀĂÈÉÊËĚĔĒÌÍÎÏĪĨĬÒÓÔÕÖŐŌÙÚÛÜŪŬŨŰàáâãäāăèéêëēěĕìíîïīĩĭòóôõöőōŏùúûüūŭũű\\-\\_]{1,55}$#', 'allowEmpty'=>false),
                        array('city', 'match', 'pattern' => '#^[a-zA-Z ÀÁÂÃÄĀĂÈÉÊËĚĔĒÌÍÎÏĪĨĬÒÓÔÕÖŐŌÙÚÛÜŪŬŨŰàáâãäāăèéêëēěĕìíîïīĩĭòóôõöőōŏùúûüūŭũű\\/\\\\\\-,\\.]{1,45}$#', 'allowEmpty'=>false),
                        array('address', 'match', 'pattern' => '#^[0-9a-zA-Z ÀÁÂÃÄĀĂÈÉÊËĚĔĒÌÍÎÏĪĨĬÒÓÔÕÖŐŌÙÚÛÜŪŬŨŰàáâãäāăèéêëēěĕìíîïīĩĭòóôõöőōŏùúûüūŭũű\\/\\\\\\-,\\.]{4,125}$#','allowEmpty'=>false),
			array('user_status', 'length', 'max'=>7),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, email, username, first_name, last_name, phone_num, city, zip_code, address, user_status, password', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'email' => 'Email',
			'username' => 'Username',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'phone_num' => 'Phone Num',
			'city' => 'City',
			'zip_code' => 'Zip Code',
			'address' => 'Address',
			'user_status' => 'User Status',
			'password' => 'Password',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('phone_num',$this->phone_num,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('zip_code',$this->zip_code,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('user_status',$this->user_status,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function validatePassword($password) {
            return $this->hashPassword($password)===$this->password;
        }
        
        public function hashPassword($password) {
            return md5($password);
        }
        
        public function generatePassword() {
            $length = 10;
            $chars = array_merge(range(0,9), range('a','z'), range('A','Z'));
            shuffle($chars);
            $password = implode(array_slice($chars, 0, $length));
            return $password;
        }
        /*
        public function beforeSave(){
            if($this->isNewRecord){          
                $this->password = hashPassword($this->password);
            }
            return parent::beforeSave();
        }
         */
}

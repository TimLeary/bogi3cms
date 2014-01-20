<?php

/**
 * This is the model class for table "media_to_object".
 *
 * The followings are the available columns in table 'media_to_object':
 * @property integer $media_to_object_id
 * @property integer $medium_id
 * @property integer $area_id
 * @property integer $object_id
 * @property string $priority
 */
class MediaToObject extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'media_to_object';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('medium_id, area_id, object_id', 'required'),
			array('medium_id, area_id, object_id', 'numerical', 'integerOnly'=>true),
			array('priority', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('media_to_object_id, medium_id, area_id, object_id, priority', 'safe', 'on'=>'search'),
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
                        'medium' => array(self::BELONGS_TO, 'Medium', 'medium_id'),
                        'area' => array(self::BELONGS_TO, 'Area', 'area_id'),
                );
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'media_to_object_id' => 'Media To Object',
			'medium_id' => 'Medium',
			'area_id' => 'Area',
			'object_id' => 'Object',
			'priority' => 'Priority',
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

		$criteria->compare('media_to_object_id',$this->media_to_object_id);
		$criteria->compare('medium_id',$this->medium_id);
		$criteria->compare('area_id',$this->area_id);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('priority',$this->priority,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MediaToObject the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getPicturesByObject($areaId,$objectId){
            $media = Yii::app()->db->createCommand()
                ->select(array('m.filename'))
                ->from('media_to_object mo')
                ->join('medium m','mo.medium_id = m.medium_id')
                ->where('mo.area_id = :areaId',array(':areaId' => $areaId))
                ->andWhere('mo.object_id = :objectId',array(':objectId' => $objectId))
                ->order(array('mo.priority ASC'))
                ->queryAll();
            
            return $media;
        }
}

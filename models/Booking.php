<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "booking".
 *
 * @property integer $id
 * @property integer $tourId
 * @property string  $email
 * @property string  $fullName
 * @property integer $babyCount
 * @property integer $childCount
 * @property integer $adultCount
 * @property string $date
 * @property string $customFields
 * @property string $customFieldValues
 */
class Booking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'booking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'fullName', 'tourId', 'babyCount', 'childCount', 'adultCount', 'date'], 'required'],
            [['tourId', 'babyCount', 'childCount', 'adultCount'], 'integer'],
            [['email', 'fullName'], 'string', 'max' => 255],
            ['email', 'email'],
            ['date', 'date', 'format' => 'yyyy-mm-dd'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'fullName' => 'Full Name',
            'tourId' => 'Tour ID',
            'babyCount' => 'Baby Count',
            'childCount' => 'Child Count',
            'adultCount' => 'Adult Count',
            'date' => 'Date',
        ];
    }
    
    public function setCustomFieldValues(array $values)
    {
        $this->customFields = serialize($values);
    }
    
    public function getCustomFieldValues()
    {
        return unserialize($this->customFields);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTour()
    {
        return $this->hasOne(Tour::className(), ['id' => 'tourId']);
    }
}

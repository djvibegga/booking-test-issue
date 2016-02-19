<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tourCustomFields".
 *
 * @property integer $tourId
 * @property integer $customFieldId
 */
class TourCustomField extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tourCustomFields';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tourId', 'customFieldId'], 'required'],
            [['tourId', 'customFieldId'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tourId' => 'Tour ID',
            'customFieldId' => 'Custom Field ID',
        ];
    }
}

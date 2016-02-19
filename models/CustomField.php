<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customField".
 *
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property integer $validatorType
 */
class CustomField extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customField';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'validatorType', 'label'], 'required'],
            ['name', 'match', 'pattern' => '/^[a-zA-Z]+$/', 'message' => 'Only latin letters are acceptable'],
            [['validatorType'], 'integer'],
            [['name', 'label'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'label' => 'Label',
            'validatorType' => 'Validator Type',
        ];
    }
}

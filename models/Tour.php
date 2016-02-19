<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tour".
 *
 * @property integer $id
 * @property string $name
 * @property string $fieldsOrderStr
 */
class Tour extends \yii\db\ActiveRecord
{
    public $fieldsOrderAvailableStr;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tour';
    }
    
    public function initFieldOrders()
    {
        $booking = Yii::$app->get('booking');
        if (empty($this->fieldsOrderStr)) {
            $this->fieldsOrderStr = implode(',', $booking->getBasicFieldNames());
        }
        if (empty($this->fieldsOrderAvailableStr)) {
            $availableFields = $booking->getAllFieldsMappedByName();
            $enabledFields = explode(',', $this->fieldsOrderStr);
            $availableIds = [];
            foreach ($availableFields as $name => $config) {
                if (in_array($name, $enabledFields)) {
                    unset($availableFields[$name]);
                }
                if (isset($config['id']) && !in_array($config['id'], $enabledFields)) {
                    unset($availableFields[$name]);
                    $availableIds[] = $config['id'];
                }
            }
            $this->fieldsOrderAvailableStr = implode(',', $availableIds);
        }
    }
    
    /**
     * (non-PHPdoc)
     * @see \yii\db\BaseActiveRecord::afterFind()
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->initFieldOrders();
    }
    
    /**
     * (non-PHPdoc)
     * @see \yii\db\BaseActiveRecord::beforeSave($insert)
     */
    public function beforeSave($insert)
    {
        if (!$insert) {
            $this->_fixEnabledFieldsStr();
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * Fixes enabled columns order string. Because it can contain values
     * from the columns availability list
     * 
     * @return void
     */
    private function _fixEnabledFieldsStr()
    {
        if (!empty($this->fieldsOrderAvailableStr) && !empty($this->fieldsOrderStr)) {
            $availableFields = explode(',', $this->fieldsOrderAvailableStr);
            $enabledFields = explode(',', $this->fieldsOrderStr);
            foreach ($enabledFields as $i => $name) {
                if (in_array($name, $availableFields)) {
                    unset($enabledFields[$i]);
                }
            }
            $this->fieldsOrderStr = implode(',', $enabledFields);
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['fieldsOrderStr', 'fieldsOrderAvailableStr'], 'string'],
            [['name'], 'string', 'max' => 128]
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
            'fieldsOrderStr' => 'Enabled fields',
            'fieldsOrderAvailable' => 'All fields'
        ];
    }
}

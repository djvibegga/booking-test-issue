<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Tour;
use yii\helpers\ArrayHelper;

/**
 * BookingForm is the model behind the booking form.
 */
class BookingForm extends Model
{
    private $_fieldNamesList = [];
    private $_fieldValues = [];
    private $_tour;
    
    public $fullName;
    public $email;
    public $date;
    
    public function __construct(Tour $tour, $config = [])
    {
        parent::__construct($config);
        $this->_tour = $tour;
        $booking = Yii::$app->get('booking');
        $this->_fieldNamesList = $booking->fieldsOrderStringToNamesList($tour->fieldsOrderStr);
        if (empty($this->_fieldNamesList)) {
            $this->_fieldNamesList = $booking->getBasicFieldNames();
        }
        foreach ($this->_fieldNamesList as $name) {
            $this->_fieldValues[$name] = '';
        } 
    }
    
    /**
     * Returns tour which is set to book
     * @return Tour
     */
    public function getTour()
    {
        return $this->_tour;
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $basicRules = [
            [['fullName', 'email', 'date'], 'required'],
            [['fullName', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            ['date', 'date', 'format' => 'dd-mm-yyyy'],
        ];
        
        $customRules = Yii::$app->get('booking')
            ->fieldsOrderStringToValidatorsList($this->_tour->fieldsOrderStr);
        
        return array_merge($basicRules, $customRules);
    }
    
    /**
     * (non-PHPdoc)
     * @see \yii\base\Model::scenarios()
     */
    public function scenarios()
    {
        return [
            'default' => ['fullName', 'email', 'date'],
            'create' => ['fullName', 'email', 'date'],
            'update' => ['fullName', 'email', 'date'],
        ];
    }
    
    public function safeAttributes()
    {
        $safeAttributes = parent::safeAttributes();
        return array_merge($safeAttributes, $this->_fieldNamesList);
    }
    
    /**
     * (non-PHPdoc)
     * @see \yii\base\Model::setAttributes($values, $safeOnly)
     */
    /*public function setAttributes($values, $safeOnly = true)
    {
        if (is_array($values) && !empty($values) && $safeOnly) {
            foreach ($values as $name => $value) {
                if (in_array($name, $this->_fieldNamesList)) {
                    $this->_fieldValues[$name] = $value;
                    unset($values[$name]);
                }
            }
        }
        parent::setAttributes($values, $safeOnly);
    }*/
    
    /**
     * (non-PHPdoc)
     * @see \yii\base\Model::attributeLabels()
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $customLabels = Yii::$app->get('booking')
            ->fieldsLabels($this->tour->fieldsOrderStr);
        return array_merge($attributeLabels, $customLabels);
    }
    
    /**
     * (non-PHPdoc)
     * @see \yii\base\Component::__get()
     */
    public function __get($name)
    {
        if (isset($this->_fieldValues[$name])) {
            return $this->_fieldValues[$name];
        }
        if (in_array($name, $this->_fieldNamesList)) {
            return '';
        }
        return parent::__get($name);
    }
    
    /**
     * (non-PHPdoc)
     * @see \yii\base\Component::__set()
     */
    public function __set($name, $value)
    {
        if (in_array($name, $this->_fieldNamesList)) {
            $this->_fieldValues[$name] = $value;
            return;
        }
        parent::__set($name, $value);
    }
    
    public function getCustomFieldValues()
    {
        return $this->_fieldValues;
    }
}

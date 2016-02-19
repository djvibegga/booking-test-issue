<?php

namespace app\components;

use yii\base\Component;
use app\models\CustomField;
use app\models\Booking;
use app\models\BookingForm;

class BookingManager extends Component
{
    CONST FIELD_VALIDATOR_INTEGER = 0;
    CONST FIELD_VALIDATOR_STRING = 1;
    CONST FIELD_VALIDATOR_BOOLEAN = 2;
    
    private $_fieldsMappedByName;
    
    public $requiredFields = [
        'babyCount' => [
            'validatorType' => self::FIELD_VALIDATOR_INTEGER,
            'label' => 'Baby Count',
        ],
        'childCount' => [
            'validatorType' => self::FIELD_VALIDATOR_INTEGER,
            'label' => 'Child Count',
        ],
        'adultCount' => [
            'validatorType' => self::FIELD_VALIDATOR_INTEGER,
            'label' => 'Adult Count',
        ],
    ];
    
    public $fieldValidatorTypes = [
        self::FIELD_VALIDATOR_INTEGER => 'integer',
        self::FIELD_VALIDATOR_STRING => 'string',
        self::FIELD_VALIDATOR_BOOLEAN => 'boolean',
    ];
    
    public $customFieldWidgetRenderMethod = [
        self::FIELD_VALIDATOR_INTEGER => 'textInput',
        self::FIELD_VALIDATOR_STRING => 'textInput',
        self::FIELD_VALIDATOR_BOOLEAN => 'checkbox',
    ];
    
    /**
     * Returns basic field names (e.g. childCount, adultCount, ...)
     * @return array
     */
    public function getBasicFieldNames()
    {
        return array_keys($this->requiredFields);
    }
    
    /**
     * Returns map of all fields (basic & custom).
     * Keys are field names, values are field configuration
     * 
     * @return array
     */
    public function getAllFieldsMappedByName()
    {
        if (!isset($this->_fieldsMappedByName)) {
            $customFields = [];
            foreach (CustomField::find()->asArray()->all() as $customField) {
                $fieldName = $customField['name'];
                unset($customField['name']);
                $customFields[$fieldName] = $customField;
            }
            $this->_fieldsMappedByName = array_merge($this->requiredFields, $customFields);
        }
        return $this->_fieldsMappedByName;
    }
    
    /**
     * Returns type of yii2 validator which is associated with
     * given validator type
     * 
     * @param int $validatorTypeId type of a validator
     *
     * @return string
     */
    public function getCustomFieldValidatorByTypeId($validatorTypeId)
    {
        return isset($this->fieldValidatorTypes[$validatorTypeId])
            ? $this->fieldValidatorTypes[$validatorTypeId]
            : 'safe';
    }
    
    /**
     * Returns a name of the yii2 method that will be used for rendering custom field
     * in the booking form page
     *
     * @param int $validatorTypeId type of a validator
     *
     * @return string
     */
    public function getCustomFieldRenderMethodByTypeId($validatorTypeId)
    {
        return isset($this->customFieldWidgetRenderMethod[$validatorTypeId])
            ? $this->customFieldWidgetRenderMethod[$validatorTypeId]
            : 'textInput';
    }
    
     /**
     * Returns a name of the yii2 method that will be used for rendering custom field
     * in the booking form page
     *
     * @param string $fieldName name of the field
     *
     * @return string
     */
    public function getCustomFieldRenderMethodByFieldName($fieldName)
    {
        if ($field = $this->getFieldByName($fieldName)) {
            return $this->getCustomFieldRenderMethodByTypeId($field['validatorType']);
        }
        return 'textInput';
    }
    
    /**
     * Returns a configuration of the field with given name
     *
     * @param string $fieldName name of the field
     *
     * @return array
     */
    public function getFieldByName($fieldName)
    {
        $mappedByName = $this->getAllFieldsMappedByName();
        return isset($mappedByName[$fieldName]) ? $mappedByName[$fieldName] : false;
    }
    
    /**
     * Returns a configuration of the field with given name
     *
     * @param string $fieldName name of the field
     *
     * @return array
     */
    public function getCustomFieldMapByIds($ids)
    {
        if (empty($ids)) {
            return [];
        }
        $query = CustomField::find();
        $query->andWhere('id IN (' . implode(',', $ids) . ')');
        $ret = [];
        foreach ($query->asArray()->all() as $item) {
            $ret[$item['id']] = $item;
        }
        return $ret;
    }
    
    /**
     * Returns list of yii2 validators for the given list of custom field ids
     *
     * @param array $ids list of custom field ids
     *
     * @return array
     */
    public function getCustomFieldValidatorsByIds($ids)
    {
        if (empty($ids)) {
            return [];
        }
        $query = CustomField::find();
        $query->andWhere('id IN (' . implode(',', $ids) . ')');
        $validators = [];
        foreach ($query->asArray()->all() as $item) {
            $validators[] = [$item['name'], $this->getCustomFieldValidatorByTypeId($item['validatorType'])];
        }
        return $validators;
    }
    
    /**
     * Returns list of yii2 validators for the basic fields list
     *
     * @return array
     */
    public function getBasicFieldValidators()
    {
        $validators = [];
        foreach ($this->requiredFields as $name => $config) {
            $validators[] = [$name, $this->getCustomFieldValidatorByTypeId($config['validatorType'])];
        }
        return $validators;
    }
    
    /**
     * Returns list of custom field names ordered in the given order
     *
     * @param string $fieldsOrderStr comma-separated list columns (ids & names)
     *
     * @return array
     */
    public function fieldsOrderStringToNamesList($fieldsOrderStr)
    {
        if (empty($fieldsOrderStr)) {
            return [];
        }
        $list = explode(',', $fieldsOrderStr);
        $customFieldIds = [];
        $namesList = [];
        foreach ($list as $orderItem) {
            if (isset($this->requiredFields[$orderItem])) {
                continue;
            } else if (is_numeric($orderItem)) {
                $customFieldIds[] = (int)$orderItem;
            } else {
                throw new \Exception('Invalid booking field name in the fields list: "' . $orderItem . '"');
            }
        }
        $customFieldMap = $this->getCustomFieldMapByIds($customFieldIds);
        foreach ($list as $orderItem) {
            if (isset($this->requiredFields[$orderItem])) {
                $namesList[] = $orderItem;
            } else if (isset($customFieldMap[$orderItem])) {
                $namesList[] = $customFieldMap[$orderItem]['name'];
            } else {
                throw new \Exception('Unknown booking field in the fields list: "' . $orderItem . '"');
            }
        }
        
        return $namesList;
    }
    
    /**
     * Returns list of validators for the fields that given in the columns sequence
     *
     * @param string $fieldsOrderStr comma-separated list columns (ids & names)
     *
     * @return array
     */
    public function fieldsOrderStringToValidatorsList($fieldsOrderStr)
    {
        $list = empty($fieldsOrderStr) ? $this->getBasicFieldNames() : explode(',', $fieldsOrderStr);
        $customFieldIds = [];
        foreach ($list as $orderItem) {
            if (isset($this->requiredFields[$orderItem])) {
                continue;
            } else if (is_numeric($orderItem)) {
                $customFieldIds[] = (int)$orderItem;
            } else {
                throw new \Exception('Invalid booking field name in the fields list: "' . $orderItem . '"');
            }
        }
        $customFieldValidators = $this->getCustomFieldValidatorsByIds($customFieldIds);
        $basicFieldValidators = $this->getBasicFieldValidators();
        return array_merge($basicFieldValidators, $customFieldValidators);
    }
    
    /**
     * Returns map of field labels
     *
     * @param string $fieldsOrderStr comma-separated list columns (ids & names)
     *
     * @return array
     */
    public function fieldsLabels($fieldsOrderStr)
    {
        $list = empty($fieldsOrderStr) ? $this->getBasicFieldNames() : explode(',', $fieldsOrderStr);
        $customFieldIds = [];
        foreach ($list as $orderItem) {
            if (isset($this->requiredFields[$orderItem])) {
                continue;
            } else if (is_numeric($orderItem)) {
                $customFieldIds[] = (int)$orderItem;
            } else {
                throw new \Exception('Invalid booking field name in the fields list: "' . $orderItem . '"');
            }
        }
        $customFieldMap = $this->getCustomFieldMapByIds($customFieldIds);
        $ret = [];
        foreach ($customFieldMap as $field) {
            $ret[$field['name']] = $field['label'];
        }
        return $ret;
    }
    
    /**
     * Creates a booking request in the database
     * @param BookingForm $form
     * @return Booking|boolean returns booking record on success, otherwise returns false
     */
    public function createBooking(BookingForm $form)
    {
        $booking = new Booking();
        $booking->tourId = $form->getTour()->id;
        $booking->date = date('Y-m-d', strtotime($form->date));
        $booking->email = $form->email;
        $booking->fullName = $form->fullName;
        
        $customFieldsValues = [];
        foreach ($form->getCustomFieldValues() as $name => $value) {
            if (isset($this->requiredFields[$name])) {
                $booking->$name = $value;
            } else {
                $customFieldsValues[$name] = $value;
            }
        }
        $booking->setCustomFieldValues($customFieldsValues);
        
        if ($booking->validate()) {
            return $booking->insert(false) ? $booking : false;
        } else {
            $form->addErrors($booking->getErrors());
        }
        
        return false;
    }
}
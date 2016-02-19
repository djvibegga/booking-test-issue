<?php

use yii\db\Migration;
use app\components\BookingManager;

class m160219_102930_seed_data extends Migration
{
    public function up()
    {
        $this->insert('customField', ['name' => 'hasWifi', 'label' => 'Has WiFi', 'validatorType' => BookingManager::FIELD_VALIDATOR_BOOLEAN]);
        $this->insert('customField', ['name' => 'latinName', 'label' => 'Latin Name', 'validatorType' => BookingManager::FIELD_VALIDATOR_STRING]);
        $this->insert('customField', ['name' => 'starsCount', 'label' => 'Hotel starts count', 'validatorType' => BookingManager::FIELD_VALIDATOR_INTEGER]);
        
        $this->insert('tour', ['name' => 'Tour 1', 'fieldsOrderStr' => 'babyCount,childCount,adultCount,1,2,3']);
        $this->insert('tour', ['name' => 'Tour 2', 'fieldsOrderStr' => '3,babyCount,childCount,adultCount']);
        $this->insert('tour', ['name' => 'Tour 3', 'fieldsOrderStr' => 'babyCount,childCount,adultCount']);
    }

    public function down()
    {
        echo "m160219_102930_seed_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}

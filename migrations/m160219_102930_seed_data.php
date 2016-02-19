<?php

use yii\db\Migration;

class m160219_102930_seed_data extends Migration
{
    public function up()
    {
        $this->insert('customField', ['name' => 'hasWifi', 'label' => 'Has WiFi', 'validatorType' => 'boolean']);
        $this->insert('customField', ['name' => 'isAllInclusive', 'label' => 'All inclusive', 'validatorType' => 'boolean']);
        $this->insert('customField', ['name' => 'starsCount', 'label' => 'Hotel starts count', 'validatorType' => 'integer']);
        
        $this->insert('tour', ['name' => 'Tour 1']);
        $this->insert('tour', ['name' => 'Tour 2']);
        $this->insert('tour', ['name' => 'Tour 3']);
        
        $this->insert('tourCustomFields', ['tourId' => 1, 'customFieldId' => 1]);
        $this->insert('tourCustomFields', ['tourId' => 1, 'customFieldId' => 2]);
        $this->insert('tourCustomFields', ['tourId' => 1, 'customFieldId' => 3]);
        $this->insert('tourCustomFields', ['tourId' => 2, 'customFieldId' => 3]);
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

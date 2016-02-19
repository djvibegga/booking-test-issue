<?php

use yii\db\Migration;

class m160219_083909_initial_structure extends Migration
{
    public function up()
    {
        $this->createTable('customField', [
            'id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT',
            'name' => 'VARCHAR(128) NOT NULL',
            'label' => 'VARCHAR(128) NOT NULL',
            'validatorType' => 'SMALLINT NOT NULL',
            'PRIMARY KEY (`id`)'
        ], 'ENGINE=InnoDB');
        
        $this->createTable('tour', [
            'id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT',
            'name' => 'VARCHAR(128) NOT NULL',
            'fieldsOrderStr' => "TEXT NOT NULL DEFAULT 'babyCount,childCount,adultCount'",
            'PRIMARY KEY (`id`)'
        ], 'ENGINE=InnoDB');
        
        $this->createTable('booking', [
            'id' => 'INT UNSIGNED NOT NULL AUTO_INCREMENT',
            'tourId' => 'INT UNSIGNED NOT NULL',
            'email' => 'VARCHAR(255) NOT NULL',
            'fullName' => 'VARCHAR(255) NOT NULL',
            'babyCount' => 'INT UNSIGNED NOT NULL',
            'childCount' => 'INT UNSIGNED NOT NULL',
            'adultCount' => 'INT UNSIGNED NOT NULL',
            'date' => 'DATE NOT NULL',
            'customFields' => 'TEXT',
            'PRIMARY KEY (`id`)'
        ], 'ENGINE=InnoDB');
        
        $this->createTable('tourCustomFields', [
            'tourId' => 'INT UNSIGNED NOT NULL',
            'customFieldId' => 'INT UNSIGNED NOT NULL',
            'PRIMARY KEY (`tourId`, `customFieldId`)'
        ], 'ENGINE=InnoDB');
    }

    public function down()
    {
        echo "m160219_083909_initial_structure cannot be reverted.\n";

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

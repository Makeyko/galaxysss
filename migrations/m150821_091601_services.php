<?php

use yii\db\Schema;
use yii\db\Migration;

class m150821_091601_services extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_services ADD id_string VARCHAR(255) NULL;');
    }

    public function down()
    {
        echo "m150821_091601_services cannot be reverted.\n";

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

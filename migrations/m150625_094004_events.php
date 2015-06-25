<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_094004_events extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_events ADD date_insert DATETIME NULL;');
    }

    public function down()
    {
        echo "m150625_094004_events cannot be reverted.\n";

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

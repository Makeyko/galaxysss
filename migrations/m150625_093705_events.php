<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_093705_events extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_events CHANGE star_date start_date DATE;');
    }

    public function down()
    {
        echo "m150625_093705_events cannot be reverted.\n";

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

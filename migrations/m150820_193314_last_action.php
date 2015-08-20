<?php

use yii\db\Schema;
use yii\db\Migration;

class m150820_193314_last_action extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_users ADD last_action int NULL;');
    }

    public function down()
    {
        echo "m150820_193314_last_action cannot be reverted.\n";

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

<?php

use yii\db\Schema;
use yii\db\Migration;

class m150723_083244_subscribe extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_users ADD subscribe_is_manual TINYINT(1) NULL;');
    }

    public function down()
    {
        echo "m150723_083244_subscribe cannot be reverted.\n";

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

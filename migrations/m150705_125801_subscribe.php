<?php

use yii\db\Schema;
use yii\db\Migration;

class m150705_125801_subscribe extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_subscribe_mail_list CHANGE date_insert date_insert int;');
    }

    public function down()
    {
        echo "m150705_125801_subscribe cannot be reverted.\n";

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

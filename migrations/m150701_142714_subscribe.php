<?php

use yii\db\Schema;
use yii\db\Migration;

class m150701_142714_subscribe extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_subscribe_mail_list ADD subject VARCHAR(255) NULL;');
    }

    public function down()
    {
        echo "m150701_142714_subscribe cannot be reverted.\n";

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

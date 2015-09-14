<?php

use yii\db\Schema;
use yii\db\Migration;

class m150913_130429_hd extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_users ADD birth_time TIME NULL;');
    }

    public function down()
    {
        echo "m150913_130429_hd cannot be reverted.\n";

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

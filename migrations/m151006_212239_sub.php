<?php

use yii\db\Schema;
use yii\db\Migration;

class m151006_212239_sub extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_subscribe_history ADD is_send TINYINT NULL;');

    }

    public function down()
    {
        echo "m151006_212239_sub cannot be reverted.\n";

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

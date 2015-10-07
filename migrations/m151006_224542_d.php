<?php

use yii\db\Schema;
use yii\db\Migration;

class m151006_224542_d extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_users_rod CHANGE kileno koleno TINYINT;');
    }

    public function down()
    {
        echo "m151006_224542_d cannot be reverted.\n";

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

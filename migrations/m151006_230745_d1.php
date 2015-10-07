<?php

use yii\db\Schema;
use yii\db\Migration;

class m151006_230745_d1 extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_users_rod ADD rod_id TINYINT NULL;');
    }

    public function down()
    {
        echo "m151006_230745_d1 cannot be reverted.\n";

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

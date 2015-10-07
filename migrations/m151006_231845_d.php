<?php

use yii\db\Schema;
use yii\db\Migration;

class m151006_231845_d extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_users_rod CHANGE name name_first VARCHAR(255);');
        $this->execute('ALTER TABLE galaxysss_1.gs_users_rod ADD name_last VARCHAR(255) NULL;');
        $this->execute('ALTER TABLE galaxysss_1.gs_users_rod ADD name_middle VARCHAR(255) NULL;');
    }

    public function down()
    {
        echo "m151006_231845_d cannot be reverted.\n";

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

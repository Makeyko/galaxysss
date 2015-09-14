<?php

use yii\db\Schema;
use yii\db\Migration;

class m150913_125951_human_design extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_users ADD human_design VARCHAR(1000) NULL;');
    }

    public function down()
    {
        echo "m150913_125951_human_design cannot be reverted.\n";

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

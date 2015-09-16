<?php

use yii\db\Schema;
use yii\db\Migration;

class m150915_223650_hd extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_users ADD birth_country int NULL;');
        $this->execute('ALTER TABLE galaxysss_1.gs_users ADD birth_town int NULL;');
    }

    public function down()
    {
        echo "m150915_223650_hd cannot be reverted.\n";

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

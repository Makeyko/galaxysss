<?php

use yii\db\Schema;
use yii\db\Migration;

class m150919_195658_users extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_users ADD zvezdnoe VARCHAR(2000) NULL;');
    }

    public function down()
    {
        echo "m150919_195658_users cannot be reverted.\n";

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

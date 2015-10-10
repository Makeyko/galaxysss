<?php

use yii\db\Schema;
use yii\db\Migration;

class m151010_004842_d1 extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_users CHANGE email email varchar(60) COLLATE ascii_general_ci;');
    }

    public function down()
    {
        echo "m151010_004842_d1 cannot be reverted.\n";

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

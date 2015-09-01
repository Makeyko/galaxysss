<?php

use yii\db\Schema;
use yii\db\Migration;

class m150901_202524_chenneling extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_cheneling_list CHANGE header header varchar(255) COLLATE utf8_general_ci;');
    }

    public function down()
    {
        echo "m150901_202524_chenneling cannot be reverted.\n";

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

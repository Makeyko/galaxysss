<?php

use yii\db\Schema;
use yii\db\Migration;

class m150911_133735_desh extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_hd CHANGE `name` title VARCHAR(255);');
        $this->execute('ALTER TABLE galaxysss_1.gs_hd CHANGE name_eng `name` VARCHAR(255);');
    }

    public function down()
    {
        echo "m150911_133735_desh cannot be reverted.\n";

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

<?php

use yii\db\Schema;
use yii\db\Migration;

class m150911_131452_desh extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_hd ADD name_eng VARCHAR(255) NULL;');
    }

    public function down()
    {
        echo "m150911_131452_desh cannot be reverted.\n";

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

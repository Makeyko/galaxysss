<?php

use yii\db\Schema;
use yii\db\Migration;

class m151104_064646_ss extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_unions_shop_tree CHANGE header name VARCHAR(255);');
    }

    public function down()
    {
        echo "m151104_064646_ss cannot be reverted.\n";

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

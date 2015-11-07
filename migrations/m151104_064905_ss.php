<?php

use yii\db\Schema;
use yii\db\Migration;

class m151104_064905_ss extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_unions_shop_tree MODIFY COLUMN id_string varchar(100) NULL;');
    }

    public function down()
    {
        echo "m151104_064905_ss cannot be reverted.\n";

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

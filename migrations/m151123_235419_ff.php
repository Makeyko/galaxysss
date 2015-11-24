<?php

use yii\db\Schema;
use yii\db\Migration;

class m151123_235419_ff extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_unions_shop_product ADD price int NULL;');
    }

    public function down()
    {
        echo "m151123_235419_ff cannot be reverted.\n";

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

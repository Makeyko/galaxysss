<?php

use yii\db\Schema;
use yii\db\Migration;

class m151103_190033_shop extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_unions_shop_product ADD union_id int NULL;');
    }

    public function down()
    {
        echo "m151103_190033_shop cannot be reverted.\n";

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

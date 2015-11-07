<?php

use yii\db\Schema;
use yii\db\Migration;

class m151104_090510_shop extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_unions_shop_product CHANGE shop_id union_id INT;');
    }

    public function down()
    {
        echo "m151104_090510_shop cannot be reverted.\n";

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

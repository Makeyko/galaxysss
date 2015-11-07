<?php

use yii\db\Schema;
use yii\db\Migration;

class m151104_092042_shop extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_unions_shop_product CHANGE date_insert date_insert int;');
    }

    public function down()
    {
        echo "m151104_092042_shop cannot be reverted.\n";

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

<?php

use yii\db\Schema;
use yii\db\Migration;

class m151103_225235_shop extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_unions_shop_product ADD image VARCHAR(255) NULL;');
    }

    public function down()
    {
        echo "m151103_225235_shop cannot be reverted.\n";

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

<?php

use yii\db\Schema;
use yii\db\Migration;

class m150909_093222_subscribe extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_subscribe_history MODIFY COLUMN content longtext NULL;');
    }

    public function down()
    {
        echo "m150909_093222_subscribe cannot be reverted.\n";

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

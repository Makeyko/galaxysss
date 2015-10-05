<?php

use yii\db\Schema;
use yii\db\Migration;

class m151005_191108_blog extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_blog CHANGE content content mediumtext;');
    }

    public function down()
    {
        echo "m151005_191108_blog cannot be reverted.\n";

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

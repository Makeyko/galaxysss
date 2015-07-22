<?php

use yii\db\Schema;
use yii\db\Migration;

class m150722_115116_praktice extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_praktice CHANGE content content longtext;');
    }

    public function down()
    {
        echo "m150722_115116_praktice cannot be reverted.\n";

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

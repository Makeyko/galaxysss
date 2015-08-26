<?php

use yii\db\Schema;
use yii\db\Migration;

class m150826_214908_chenneling extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_cheneling_tree MODIFY COLUMN id_string varchar(100) NULL;');
    }

    public function down()
    {
        echo "m150826_214908_chenneling cannot be reverted.\n";

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

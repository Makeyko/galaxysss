<?php

use yii\db\Schema;
use yii\db\Migration;

class m150821_100605_services extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_services DROP id_string;');
    }

    public function down()
    {
        echo "m150821_100605_services cannot be reverted.\n";

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

<?php

use yii\db\Schema;
use yii\db\Migration;

class m150821_094259_services extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_services ADD is_added_site_update TINYINT(1) NULL;');
    }

    public function down()
    {
        echo "m150821_094259_services cannot be reverted.\n";

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

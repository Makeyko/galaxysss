<?php

use yii\db\Schema;
use yii\db\Migration;

class m150708_143329_site_update extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_site_update CHANGE date_insert date_insert int;');
    }

    public function down()
    {
        echo "m150708_143329_site_update cannot be reverted.\n";

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

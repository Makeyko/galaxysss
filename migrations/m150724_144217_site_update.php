<?php

use yii\db\Schema;
use yii\db\Migration;

class m150724_144217_site_update extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_site_update ADD type TINYINT(1) NULL;');
        $this->execute('update galaxysss_1.gs_site_update set `type` =1;');
    }

    public function down()
    {
        echo "m150724_144217_site_update cannot be reverted.\n";

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

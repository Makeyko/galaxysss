<?php

use yii\db\Schema;
use yii\db\Migration;

class m150701_104000_subscribe extends Migration
{
    public function up()
    {
        // новости сайта
        $this->execute('ALTER TABLE galaxysss_1.gs_users ADD subscribe_is_news TINYINT(1) NULL;');
        // обновления сайта
        $this->execute('ALTER TABLE galaxysss_1.gs_users ADD subscribe_is_site_update TINYINT(1) NULL;');
        // mailing
        $this->execute('ALTER TABLE galaxysss_1.gs_users ADD subscribe_is_mailing  TINYINT(1) NULL;');
    }


    public function down()
    {
        echo "m150701_104000_subscribe cannot be reverted.\n";

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

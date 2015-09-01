<?php

use yii\db\Schema;
use yii\db\Migration;

class m150901_160313_article extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_article_list ADD is_added_site_update TINYINT NULL;');
    }

    public function down()
    {
        echo "m150901_160313_article cannot be reverted.\n";

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

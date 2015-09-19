<?php

use yii\db\Schema;
use yii\db\Migration;

class m150919_003251_events extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_events ADD is_added_site_update TINYINT NULL;');
    }

    public function down()
    {
        echo "m150919_003251_events cannot be reverted.\n";

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

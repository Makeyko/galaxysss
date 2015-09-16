<?php

use yii\db\Schema;
use yii\db\Migration;

class m150915_144245_hd extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_hd_town_rect ADD google_data VARCHAR(2000) NULL;');
    }

    public function down()
    {
        echo "m150915_144245_hd cannot be reverted.\n";

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

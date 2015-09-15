<?php

use yii\db\Schema;
use yii\db\Migration;

class m150915_000548_hd extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_hd_town ADD lat_min FLOAT NULL;');
        $this->execute('ALTER TABLE galaxysss_1.gs_hd_town ADD lat_max FLOAT NULL;');
        $this->execute('ALTER TABLE galaxysss_1.gs_hd_town ADD lng_min FLOAT NULL;');
        $this->execute('ALTER TABLE galaxysss_1.gs_hd_town ADD lng_max FLOAT NULL;');
    }

    public function down()
    {
        echo "m150915_000548_hd cannot be reverted.\n";

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

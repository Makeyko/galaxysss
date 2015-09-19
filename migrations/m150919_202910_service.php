<?php

use yii\db\Schema;
use yii\db\Migration;

class m150919_202910_service extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_services ADD id_string VARCHAR(30) NULL;');
    }

    public function down()
    {
        echo "m150919_202910_service cannot be reverted.\n";

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

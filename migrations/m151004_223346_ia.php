<?php

use yii\db\Schema;
use yii\db\Migration;

class m151004_223346_ia extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_investigator ADD name VARCHAR(255) NULL;');
    }

    public function down()
    {
        echo "m151004_223346_ia cannot be reverted.\n";

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

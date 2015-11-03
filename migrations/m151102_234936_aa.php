<?php

use yii\db\Schema;
use yii\db\Migration;

class m151102_234936_aa extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_smeta ADD date_insert int NULL;');
    }

    public function down()
    {
        echo "m151102_234936_aa cannot be reverted.\n";

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

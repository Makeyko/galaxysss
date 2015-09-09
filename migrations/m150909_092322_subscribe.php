<?php

use yii\db\Schema;
use yii\db\Migration;

class m150909_092322_subscribe extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_users ADD subscribe_is_1 TINYINT NULL;');
        $this->execute('update galaxysss_1.gs_users set subscribe_is_1=1 WHEre id=48;');
    }

    public function down()
    {
        echo "m150909_092322_subscribe cannot be reverted.\n";

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

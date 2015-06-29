<?php

use yii\db\Schema;
use yii\db\Migration;

class m150629_145636_chenneling_tree extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_events MODIFY COLUMN start_time time NULL;');
        $this->execute('ALTER TABLE galaxysss_1.gs_events MODIFY COLUMN end_time time NULL;');
    }

    public function down()
    {
        echo "m150629_145636_chenneling_tree cannot be reverted.\n";

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

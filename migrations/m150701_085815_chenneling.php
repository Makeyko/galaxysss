<?php

use yii\db\Schema;
use yii\db\Migration;

class m150701_085815_chenneling extends Migration
{
    public function up()
    {
        $this->insert('gs_cheneling_tree', [
            'name'      => 'Цивилизация Хамиля',
            'parent_id' => 6,
        ]);
        $this->insert('gs_cheneling_tree', [
            'name'      => 'Ирина',
            'parent_id' => 5,
        ]);

    }

    public function down()
    {
        echo "m150701_085815_chenneling cannot be reverted.\n";

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

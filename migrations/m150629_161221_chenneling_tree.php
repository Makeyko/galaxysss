<?php

use yii\db\Schema;
use yii\db\Migration;

class m150629_161221_chenneling_tree extends Migration
{
    public function up()
    {
        $this->insert('gs_cheneling_tree', [
            'name'      => 'Татьяна Мироненко',
            'parent_id' => 5,
        ]);
        $this->insert('gs_cheneling_tree', [
            'name'      => 'Эль Мория',
            'parent_id' => 6,
        ]);
        $this->insert('gs_cheneling_tree', [
            'name'      => 'Плеяды',
            'parent_id' => 6,
        ]);
        $this->insert('gs_cheneling_tree', [
            'name'      => 'Хранители Хроник Акаши Земли',
            'parent_id' => 6,
        ]);
    }

    public function down()
    {
        echo "m150629_161221_chenneling_tree cannot be reverted.\n";

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

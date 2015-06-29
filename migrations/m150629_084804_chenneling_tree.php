<?php

use yii\db\Schema;
use yii\db\Migration;

class m150629_084804_chenneling_tree extends Migration
{
    public function up()
    {
        $this->delete('gs_cheneling_tree');
        $this->batchInsert('gs_cheneling_tree', ['id', 'parent_id', 'name', 'id_string'], [
            [1, NULL, 'Видео', ''],
            [2, 5, 'Майк Куинси', ''],
            [3, 6, 'Люцифер', ''],
            [4, 5, 'Арктурианская группа', ''],
            [5, NULL, 'Контактеры', ''],
            [6, NULL, 'Высшие Силы', ''],
            [7, 6, 'Салуса с Сириуса', ''],
        ]);
        $this->execute('ALTER TABLE galaxysss_1.gs_cheneling_tree ADD sort_index int NULL;');
    }

    public function down()
    {
        echo "m150629_084804_chenneling_tree cannot be reverted.\n";

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

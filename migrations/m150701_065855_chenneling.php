<?php

use yii\db\Schema;
use yii\db\Migration;

class m150701_065855_chenneling extends Migration
{
    public function up()
    {
        $this->insert('gs_cheneling_tree', [
            'name' => 'Послания',
        ]);
        $id = Yii::$app->db->getLastInsertID();
        $this->insert('gs_cheneling_tree', [
            'name' => 'Практики',
        ]);
        $this->update('gs_cheneling_tree', [
            'parent_id' => $id,
        ], [
            'in',
            'id',
            [
                1,
                5,
                6
            ]
        ]);
        $this->execute('update gs_cheneling_list set tree_node_id_mask=tree_node_id_mask & :mask', [':mask' => (new \cs\services\BitMask([$id]))->getMask()]);
    }

    public function down()
    {
        echo "m150701_065855_chenneling cannot be reverted.\n";

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

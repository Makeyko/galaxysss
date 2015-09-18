<?php

use yii\db\Schema;
use yii\db\Migration;

class m150918_004750_pictures extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` VARCHAR(255) DEFAULT NULL,
  `is_added` tinyint DEFAULT NULL,
    `tree_node_id_mask` bigint(20) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        echo "m150918_004750_pictures cannot be reverted.\n";

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

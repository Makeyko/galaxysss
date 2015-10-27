<?php

use yii\db\Schema;
use yii\db\Migration;

class m151026_141001_shop extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_unions_shop_tree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `union_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `header` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `date_insert` datetime DEFAULT NULL,
  `sort_index` int(11) DEFAULT NULL,
  `description` varchar(2000) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `id_string` varchar(100) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8');
        $this->execute('CREATE TABLE `gs_unions_shop_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tree_node_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `date_insert` datetime DEFAULT NULL,
  `sort_index` int(11) DEFAULT NULL,
  `description` varchar(2000) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        echo "m151026_141001_shop cannot be reverted.\n";

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

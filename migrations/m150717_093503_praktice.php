<?php

use yii\db\Schema;
use yii\db\Migration;

class m150717_093503_praktice extends Migration
{
    public function up()
    {
        $this->execute("CREATE TABLE `gs_parktice` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `header` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `image` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_bin,
  `source` varchar(255) CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL,
  `date_insert` int DEFAULT NULL,
  `date` DATE DEFAULT NULL,
  `id_string` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `view_counter` int(11) NOT NULL DEFAULT '0',
  `description` varchar(1000) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tree_node_id_mask` bigint(20) DEFAULT NULL,
  `is_added_site_update` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tree_node_id_mask` (`tree_node_id_mask`),
  KEY `id_string` (`id_string`),
  KEY `date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8");
    }

    public function down()
    {
        echo "m150717_093503_praktice cannot be reverted.\n";

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

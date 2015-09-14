<?php

use yii\db\Schema;
use yii\db\Migration;

class m150913_073905_blog extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(255) DEFAULT NULL,
  `content` text,
  `date_insert` int DEFAULT NULL,
  `date_update` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `id_string` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `view_counter` int(11) NOT NULL DEFAULT 0,
  `description` varchar(1000) DEFAULT NULL,
  `is_added_site_update` tinyint(1) DEFAULT NULL,
    `tree_node_id_mask` bigint(20) DEFAULT NULL,
PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_string` (`id_string`),
  KEY `date` (`date`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        echo "m150913_073905_blog cannot be reverted.\n";

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

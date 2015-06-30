<?php

use yii\db\Schema;
use yii\db\Migration;

class m150630_141441_events extends Migration
{
    public function up()
    {
        $this->execute('drop table gs_events');
        $this->execute('CREATE TABLE `gs_events` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_date` date NOT NULL,
  `end_time` time DEFAULT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `image` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_insert` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
    }

    public function down()
    {
        echo "m150630_141441_events cannot be reverted.\n";

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

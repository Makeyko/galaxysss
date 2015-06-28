<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_092902_events extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE IF NOT EXISTS `gs_events` (
`id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `star_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_date` date NOT NULL,
  `end_time` time NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `image` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;');
    }

    public function down()
    {
        echo "m150625_092902_events cannot be reverted.\n";

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

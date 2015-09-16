<?php

use yii\db\Schema;
use yii\db\Migration;

class m150915_143851_hd extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_hd_town_rect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `town_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `lat_min` float DEFAULT NULL,
  `lat_max` float DEFAULT NULL,
  `lng_min` float DEFAULT NULL,
  `lng_max` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        echo "m150915_143851_hd cannot be reverted.\n";

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

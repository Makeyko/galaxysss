<?php

use yii\db\Schema;
use yii\db\Migration;

class m150701_110937_subscribe extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_site_update` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `image` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `link` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `date_insert` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        echo "m150701_110937_subscribe cannot be reverted.\n";

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

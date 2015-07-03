<?php

use yii\db\Schema;
use yii\db\Migration;

class m150701_141105_subscribe extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_subscribe_mail_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `text` TEXT NOT NULL,
  `html` TEXT NOT NULL,
  `date_insert` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        echo "m150701_141105_subscribe cannot be reverted.\n";

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

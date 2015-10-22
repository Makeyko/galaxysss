<?php

use yii\db\Schema;
use yii\db\Migration;

class m151018_211443_magaz extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_unions_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `sub_type` varchar(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        echo "m151018_211443_magaz cannot be reverted.\n";

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

<?php

use yii\db\Schema;
use yii\db\Migration;

class m150909_234513_invistigator extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_investigator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL,
  `url` varchar(255) CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL,
  `date_insert` int DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8');
    }

    public function down()
    {
        echo "m150909_234513_invistigator cannot be reverted.\n";

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

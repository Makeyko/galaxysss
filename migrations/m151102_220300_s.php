<?php

use yii\db\Schema;
use yii\db\Migration;

class m151102_220300_s extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_smeta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `target` varchar(2000) DEFAULT NULL,
  `present` varchar(2000) DEFAULT NULL,
  `price` int DEFAULT NULL,
  `bill` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        echo "m151102_220300_s cannot be reverted.\n";

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

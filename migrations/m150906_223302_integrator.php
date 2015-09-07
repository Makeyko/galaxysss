<?php

use yii\db\Schema;
use yii\db\Migration;

class m150906_223302_integrator extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_channeling_investigator` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `id_string` varchar(255) DEFAULT NULL,
  `is_added` tinyint DEFAULT NULL,
  `date_insert` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        echo "m150906_223302_integrator cannot be reverted.\n";

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

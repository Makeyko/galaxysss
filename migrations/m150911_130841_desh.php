<?php

use yii\db\Schema;
use yii\db\Migration;

class m150911_130841_desh extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_hd_town` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->execute('ALTER TABLE galaxysss_1.gs_hd ADD sub_type VARCHAR(10) NULL;');
    }

    public function down()
    {
        echo "m150911_130841_desh cannot be reverted.\n";

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

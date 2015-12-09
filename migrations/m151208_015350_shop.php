<?php

use yii\db\Schema;
use yii\db\Migration;

class m151208_015350_shop extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_users_shop_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `union_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `date_create` int DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        echo "m151208_015350_shop cannot be reverted.\n";

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

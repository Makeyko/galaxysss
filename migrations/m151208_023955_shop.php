<?php

use yii\db\Schema;
use yii\db\Migration;

class m151208_023955_shop extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_users_shop_requests_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `count` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        echo "m151208_023955_shop cannot be reverted.\n";

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

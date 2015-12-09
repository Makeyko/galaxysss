<?php

use yii\db\Schema;
use yii\db\Migration;

class m151208_061044_shop extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_users_shop_requests_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) DEFAULT NULL,
  `direction` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `datetime` int DEFAULT NULL,
  `message` VARCHAR(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->execute('ALTER TABLE galaxysss_1.gs_users_shop_requests ADD is_answer_from_shop TINYINT(1) NULL;');
        $this->execute('ALTER TABLE galaxysss_1.gs_users_shop_requests ADD is_answer_from_client TINYINT(1) NULL;');
    }

    public function down()
    {
        echo "m151208_061044_shop cannot be reverted.\n";

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

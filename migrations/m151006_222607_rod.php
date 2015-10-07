<?php

use yii\db\Schema;
use yii\db\Migration;

class m151006_222607_rod extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_users_rod` (
  `id`          INT(11) NOT NULL AUTO_INCREMENT,
  `gender`      TINYINT      DEFAULT NULL,
  `name`        VARCHAR(255) DEFAULT NULL,
  `date_born`   DATE         DEFAULT NULL,
  `date_death`  DATE         DEFAULT NULL,
  `kileno`      TINYINT      DEFAULT NULL,
  `child_id`    TINYINT      DEFAULT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  `content`     TEXT         DEFAULT NULL,
  `image`       VARCHAR(255) DEFAULT NULL,
  `user_id`     INT     NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8');
    }

    public function down()
    {
        echo "m151006_222607_rod cannot be reverted.\n";

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

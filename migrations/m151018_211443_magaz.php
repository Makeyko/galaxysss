<?php

use yii\db\Schema;
use yii\db\Migration;

class m151018_211443_magaz extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_unions_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `union_id` int DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `dostavka` text,
  `admin_email` varchar(255),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->execute('ALTER TABLE galaxysss_1.gs_article_list CHANGE content content LONGTEXT;');
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

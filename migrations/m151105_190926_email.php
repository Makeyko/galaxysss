<?php

use yii\db\Schema;
use yii\db\Migration;

class m151105_190926_email extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE IF NOT EXISTS `gs_users_email_change` (
  `id` int(10) unsigned NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `code` varchar(60) DEFAULT NULL,
  `date_finish` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');
    }

    public function down()
    {
        echo "m151105_190926_email cannot be reverted.\n";

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

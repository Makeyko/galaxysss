<?php

use yii\db\Schema;
use yii\db\Migration;

class m150913_080122_blog extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE `gs_blog_tree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `sort_index` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8');
            $this->insert('gs_blog_tree',[
                'name' => 'Корень',
            ]);
    }

    public function down()
    {
        echo "m150913_080122_blog cannot be reverted.\n";

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

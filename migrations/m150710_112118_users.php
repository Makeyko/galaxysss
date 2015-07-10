<?php

use yii\db\Schema;
use yii\db\Migration;
use app\models\User;

class m150710_112118_users extends Migration
{
    public function up()
    {
        $rows = User::query(['not', ['email' => null]])->select('id,email')->all();
        foreach($rows as $row) {
            $this->execute('update gs_users set `email`=\''.strtolower($row['email']).'\' where id='.$row['id']);
        }
    }

    public function down()
    {
        echo "m150710_112118_users cannot be reverted.\n";

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

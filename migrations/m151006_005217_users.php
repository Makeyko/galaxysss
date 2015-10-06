<?php

use yii\db\Schema;
use yii\db\Migration;

class m151006_005217_users extends Migration
{
    public function up()
    {
        foreach (\app\models\User::query(['referal_code' => null])->select('id')->column() as $id) {
            $this->update(\app\models\User::TABLE, ['referal_code' => \cs\services\Security::generateRandomString(20)], ['id' => $id]);
        }
    }

    public function down()
    {
        echo "m151006_005217_users cannot be reverted.\n";

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

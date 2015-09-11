<?php

use yii\db\Schema;
use yii\db\Migration;

class m150911_100532_chenneling extends Migration
{
    public function up()
    {
        $all = \app\models\Chenneling::query(['description' => null])->all();
        foreach($all as $item) {
            $i = new \app\models\Chenneling($item);
            $i->update(['description' => \app\services\GsssHtml::getMiniText($i->getField('content'))]);
        }
    }

    public function down()
    {
        echo "m150911_100532_chenneling cannot be reverted.\n";

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

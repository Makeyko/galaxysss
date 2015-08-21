<?php

use yii\db\Schema;
use yii\db\Migration;

class m150821_090321_services extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_services ADD column_name int NULL;');
        $rows = \app\models\Service::query()->select(['id', 'date_insert'])->all();
        foreach($rows as $row) {
            $date = new DateTime($row['date_insert']);
            \app\models\Service::find($row['id'])->update(['column_name' => $date->format('U')]);
        }
        // удаляю старую колонку
        $this->execute('ALTER TABLE galaxysss_1.gs_services DROP date_insert;');
        // переименовываю вновь созданную колонку
        $this->execute('ALTER TABLE galaxysss_1.gs_services CHANGE column_name date_insert int NULL;');
    }

    public function down()
    {
        echo "m150821_090321_services cannot be reverted.\n";

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

<?php

use yii\db\Schema;
use yii\db\Migration;

class m150911_132625_desh extends Migration
{
    public function up()
    {
        require_once(\Yii::getAlias('@csRoot/services/simplehtmldom_1_5/simple_html_dom.php'));

        foreach(\app\models\HD::query()->all() as $item) {
            echo $item['name'] . ' => ';
            $doc = str_get_html($item['content']);
            $p = $doc->find('p');
            $fields = [];
            if (count($p) > 0) {
                $sub_type = trim($p[0]->plaintext);
                $fields['sub_type'] = $sub_type;
                $items = $doc->find('select/option');
                $new = [];
                foreach($items as $i) {
                    $new [] = [
                        $item['id'],
                        trim($i->attr['value']),
                        trim($i->plaintext),
                    ];
                }
                if (count($new) > 0) {
                    \app\models\HDtown::batchInsert(['country_id','name','title'], $new);
                }
            } else {
                $i = $doc->find('input[name="city"]');
                \app\models\HDtown::insert([
                    'country_id' => $item['id'],
                    'name' => trim($i[0]->attr['value']),
                ]);
            }
            $i = $doc->find('input[name="country_en"]');
            if (count($i) > 0) {
                $fields['name_eng'] = $i[0]->attr['value'];
            }
            if (count($fields)) {
                (new \app\models\HD($item))->update($fields);
            }
            echo 'ok' . "\n";
        }
    }

    public function down()
    {
        echo "m150911_132625_desh cannot be reverted.\n";

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

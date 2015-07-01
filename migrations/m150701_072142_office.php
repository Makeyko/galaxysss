<?php

use yii\db\Schema;
use yii\db\Migration;
use cs\services\Str;
use yii\helpers\StringHelper;
use yii\helpers\Html;

class m150701_072142_office extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_1.gs_unions_office ADD category VARCHAR(100) NULL;');

        $path = Yii::getAlias('@app/app/assets/1.xml');
        $data = file_get_contents($path);
        $x = new \DOMDocument();
        $x->loadXML($data);

        $ret = [];
        /** @var \DOMElement $element */
        foreach ($x->documentElement->childNodes as $element) {
            if ($element instanceof \DOMElement) {
                $data = $element->getAttribute('data-jmapping');
                $pos = Str::pos('lat', $data);
                $pos1 = Str::pos('lng', $data);
                $lat = Str::sub($data, $pos + 5, $pos1 - $pos - 7);
                $pos = Str::pos('lng', $data);
                $pos1 = Str::pos('category', $data);
                $lng = Str::sub($data, $pos + 5, $pos1 - $pos - 8);
                $pos = Str::pos('category', $data);
                $category = Str::sub($data, $pos + 11);
                $category = Str::sub($category, 0, Str::length($category) - 2);
                $category = explode('|', $category);
                $list = $element->getElementsByTagName("p");
                if ($list->length == 1) {
                    /** @var \DOMElement $content */
                    $content = $list->item(0);
                    $content = $x->saveXML($content);

                    $content = Str::sub($content, 3);
                    $content = Str::sub($content, 0, Str::length($content) - 4);
                    $content = explode('<br/>', $content);
                    $ret2 = [];
                    foreach ($content as $item) {
                        if (StringHelper::startsWith($item, '<b>')) {
                            $item = Str::sub($item, 3);
                            $item = Str::sub($item, 0, Str::length($item) - 4);
                        }
                        $ret2[] = trim($item);
                    }
                    $name = $ret2[0];
                    array_shift($ret2);
                    if (StringHelper::startsWith($ret2[ count($ret2) - 1 ], 'Открытие')) {
                        $ret2 = array_reverse($ret2);
                        array_shift($ret2);
                        $ret2 = array_reverse($ret2);
                    }
                    if (StringHelper::startsWith($ret2[ count($ret2) - 1 ], '"ВкусВилл')) {
                        $ret2 = array_reverse($ret2);
                        array_shift($ret2);
                        $ret2 = array_reverse($ret2);
                    }
                    $address = $ret2[0];
                    array_shift($ret2);


                    $ret[] = [
                        392,
                        $address,
                        $name,
                        $lat,
                        $lng,
                        join('|', $category),
                        Html::tag('p', join('<br/>', $ret2)),
                    ];
                }
            }
        }

        $this->batchInsert('gs_unions_office', [
            'union_id',
            'point_address',
            'name',
            'point_lat',
            'point_lng',
            'category',
            'content',
        ], $ret);

    }

    public function down()
    {
        echo "m150701_072142_office cannot be reverted.\n";

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

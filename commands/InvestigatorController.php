<?php

namespace app\commands;

use app\models\SubscribeMailItem;
use app\services\investigator\Collection;
use cs\Application;
use yii\console\Controller;
use yii\console\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * Занимается слежением за посланиями
 */
class InvestigatorController extends Controller
{
    /**
     * Делает рассылку писем из списка рассылки
     */
    public function actionIndex()
    {
        $items = [];
        $list = Collection::getList();
        $c = 1;
        foreach($list as $item) {
            $class = $item['class'];
            /** @var \app\services\investigator\InvestigatorInterface $class */
            $class = new $class();
            $className = $class->className();
            $new = $class->getNewItems();
            foreach($new as $i) {
                $i['class'] = $className;
                $i['id'] = $c;
                $items[] = $i;
                $c++;
            }
        }
        if (count($items) > 0) {
            Application::mail('god@galaxysss.ru', 'Появились новые послания', 'new_channeling', [
                'items' => $items
            ]);
        }
    }
}

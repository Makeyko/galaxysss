<?php

namespace app\commands;

use app\models\Investigator;
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
    public $isEcho = 1;
    const KEY_NAME = '\app\commands\InvestigatorController::getIndex';

    /**
     * Делает рассылку писем из списка рассылки
     */
    public function actionIndex($isEcho = 1)
    {
        $this->isEcho = $isEcho;
        $items = [];
        $list = Collection::getList();
        $c = $this->getIndex();
        $c++;

        if ($c >= count($list)) {
            $c = 0;
        }
        $item = $list[ $c ];
        $class = $item['class'];
        self::log('класс = ', $class);
        /** @var \app\services\investigator\InvestigatorInterface $class */
        $class = new $class();
        $className = $class->className();
        $new = $class->getNewItems();
        foreach ($new as $i) {
            $i['class'] = $className;
            $i['id'] = $c;
            $items[] = $i;
        }

        if (count($items) > 0) {
            Application::mail('god@galaxysss.ru', 'Появились новые послания', 'new_channeling', [
                'items' => $items
            ]);

            self::log('новые = ', $items);
        } else {
            self::log('Нет ничего');
        }

        // доавляю
        {
            // получаю какие есть
            $existList = Investigator::query([
                'class_name' => $className,
                'status'     => \app\models\Investigator::STATUS_NEW,
            ])->select('url')->column();
            // добавляю свежие
            $rows = [];
            foreach ($items as $i) {
                if (!in_array($i['url'], $existList)) {
                    $rows[] = [
                        $i['class'],
                        $i['url'],
                        $i['name'],
                        time(),
                        \app\models\Investigator::STATUS_NEW
                    ];
                }
            }
            // добавляю в БД
            if (count($rows) > 0) {
                Investigator::batchInsert([
                    'class_name',
                    'url',
                    'name',
                    'date_insert',
                    'status',
                ], $rows);
            }
        }

        $this->setIndex($c);
    }

    /**
     * Получает индекс листа который был в прошлый раз
     *
     * @return int
     */
    public function getIndex()
    {
        $value = \Yii::$app->cache->get(self::KEY_NAME);

        return ($value === false) ? 0 : $value;
    }

    public function setIndex($index)
    {
        \Yii::$app->cache->set(self::KEY_NAME, $index);
    }

    public function log($var, $var2 = null)
    {
        if ($this->isEcho != 1) {
            return;
        }
        if (is_string($var)) {
            echo $var;
        } else {
            echo VarDumper::dumpAsString($var, 10, false);
        }
        if ($var2) {
            if (is_string($var2)) {
                echo $var2;
            } else {
                echo VarDumper::dumpAsString($var2, 10, false);
            }
        }

        echo "\n";
    }


    public function actionTest($a = null)
    {
        print_r([$_SERVER,$a]);
    }
}

<?php

namespace app\controllers;

use app\models\Article;
use app\models\Chenneling;
use app\models\Form\Investigator;
use app\services\investigator\Collection;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;
use yii\helpers\StringHelper;

class Admin_investigatorController extends AdminBaseController
{

    public function actionIndex()
    {
        if (count(Yii::$app->request->post()) > 0) {
            $formValues = Yii::$app->request->post((new Investigator())->formName());
            $add = [];
            $skip = [];
            foreach($formValues as $name => $value) {
                if (StringHelper::startsWith($name, 'id')) {
                    $id = substr($name, 2);
                    foreach(Yii::$app->session->get('items') as $sessionItem) {
                        if ($sessionItem['id'] == $id) {
                            switch($value) {
                                // пропустить
                                case 1:
                                    $skip[] = [
                                        $sessionItem['class'],
                                        $sessionItem['url'],
                                        time(),
                                        1,
                                    ];
                                    break;
                                // добавить
                                case 2:
                                    $add[] = [
                                        $sessionItem['class'],
                                        $sessionItem['url'],
                                        time(),
                                        2,
                                    ];
                                    break;
                            }
                        }
                    }
                }
            }
            if (count($skip) > 0) {
                \app\models\Investigator::batchInsert([
                    'class_name',
                    'url',
                    'date_insert',
                    'status',
                ], $skip);
            }
            foreach($add as $item) {
                $class = $item[0];
                // послание
                /** @var \app\services\investigator\InvestigatorInterface $class */
                $class = new $class();
                $extractor = $class->getItem($item[1]);
                // добавляю
                Chenneling::insertExtractorInterface($extractor);
            }
            if (count($add) > 0) {
                \app\models\Investigator::batchInsert([
                    'class_name',
                    'url',
                    'date_insert',
                    'status',
                ], $add);
            }
            Yii::$app->session->remove('items');
            Yii::$app->session->setFlash('contactFlash');

            return $this->render([
            ]);
        } else {
            $start1 = microtime(true);
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
            Yii::$app->session->set('items', $items);
            $diff = (float)(microtime(true) - $start1);
            Yii::info('all: ' . $diff, 'gs\\time');
            return $this->render([
                'items' => $items,
            ]);
        }
    }

}

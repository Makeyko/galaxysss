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
use yii\db\Query;
use yii\helpers\StringHelper;
use \app\models\Investigator as Inv;

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
                                        $sessionItem['id'],
                                    ];
                                    break;
                                // добавить
                                case 2:
                                    $add[] = [
                                        $sessionItem['id'],
                                    ];
                                    break;
                            }
                        }
                    }
                }
            }
            if (count($skip) > 0) {
                (new Query())->createCommand()->update(Inv::TABLE, ['status' => Inv::STATUS_SKIP], ['in', 'id', $skip])->execute();
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
                (new Query())->createCommand()->update(Inv::TABLE, ['status' => Inv::STATUS_ADD], ['in', 'id', $add])->execute();
            }
            Yii::$app->session->remove('items');
            Yii::$app->session->setFlash('contactFlash');

            return $this->render([]);
        } else {
            $items = \app\models\Investigator::query(['status' => \app\models\Investigator::STATUS_NEW])
                ->select([
                    'class_name as class',
                    'id',
                    'url',
                    'date_insert',
                    'status',
                    'name',
                ])
                ->all();
            Yii::$app->session->set('items', $items);

            return $this->render([
                'items' => $items,
            ]);
        }
    }

}

<?php


/*
 *
 * Трейт для контроллера сайта чтобы работал виджет autocomplite
 *
'place/town/<id:\\d+>'             => 'site/place_town',
'place/region/<id:\\d+>'           => 'site/place_region',
'place/country'                    => 'site/place_country',
*/

namespace cs\Widget\Place;

use yii\helpers\Json;

trait TraitController
{

    /**
     * Возращает список городов по запросу get param=term
     *
     * @return string JSON
     */
    public function actionPlace_country()
    {
        $term = \Yii::$app->request->get('term');

        return Json::encode(
            \cs\models\Place\Country::findAll($term)
        );
    }

    /**
     * Возращает список городов по запросу get param=term
     *
     * @return string JSON
     */
    public function actionPlace_town($id)
    {
        $term = \Yii::$app->request->get('term');

        return Json::encode(
            \cs\models\Place\Town::findAll($term, $id)
        );
    }

    /**
     * Возращает список городов по запросу get param=term
     *
     * @return string JSON
     */
    public function actionPlace_town_all()
    {
        $term = \Yii::$app->request->get('term');

        return Json::encode(
            \cs\models\Place\Town::findAll($term)
        );
    }

    /**
     * Возращает список городов по запросу get param=term
     *
     * @return string JSON
     */
    public function actionPlace_region($id)
    {
        $term = static::getParam('term');

        return Json::encode(
            \cs\models\Place\Region::findAll($term, $id)
        );
    }
}
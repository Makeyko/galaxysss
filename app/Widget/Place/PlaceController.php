<?php


/**
 * Контроллер для виджета Place
 *
 * в конфиг web.php нужно прописать в controllerMap
 * 'controllerMap' => [
 *     'place' => 'cs\Widget\Place\PlaceController',
 *     // ...
 * ],
 *
 * в правила роутинга надо прописать:
 *
 * 'place/town/all'                   => 'place/place_town_all',
 * 'place/town/<id:\\d+>'             => 'place/place_town',
 * 'place/region/<id:\\d+>'           => 'place/place_region',
 * 'place/country'                    => 'place/place_country',
 * 
 * 'place/town'
 * 'place/region'
 * 'place/country'

 */

namespace cs\Widget\Place;

use yii\helpers\Json;
use yii\web\Response;

class PlaceController extends \cs\base\BaseController
{
	/**
	 * REQUEST:
	 * - term str
	 * - country int or empty
	 * - region int or empty
	 * @return array
	 */
	public function actionTown() {
		$term = \Yii::$app->request->get('term');
		$country = \Yii::$app->request->get('country');
		$region = \Yii::$app->request->get('region');
		\Yii::$app->response->format = Response::FORMAT_JSON;
        return \cs\models\Place\Town::findAll($term, $country, $region);
	}
	
	/**
	 * REQUEST:
	 * - term str
	 * - country int or empty
	 * @return array
	 */
	public function actionRegion() {
		$term = \Yii::$app->request->get('term');
		$country = \Yii::$app->request->get('country');
		\Yii::$app->response->format = Response::FORMAT_JSON;
        return \cs\models\Place\Region::findAll($term, $country);
	}
	
	/**
	 * REQUEST:
	 * - term str
	 * @return array
	 */
	public function actionCountry() {
		$term = \Yii::$app->request->get('term');
		\Yii::$app->response->format = Response::FORMAT_JSON;
        return \cs\models\Place\Country::findAll($term);
	}

}
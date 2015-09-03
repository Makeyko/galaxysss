<?php
/**

 */

namespace cs\modules\log;

use cs\base\BaseController;
use cs\services\VarDumper;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Html;

class LogController extends BaseController
{
    public $layout = '@app/views/layouts/cabinet';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@','?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Разбивает строку '[127.0.0.1][1][-]' на три элемента
     *
     * @param $str
     *
     * @return array
     */
    public static function parseString($str)
    {
        $arr = explode('][', ']' . $str . '[');

        return array_slice($arr, 1, 3);
    }

    public function actionLog()
    {

        $query = (new Query())->select('*')->from('log')->orderBy(['log_time' => SORT_DESC]);
        $level = self::getParam('level');
        $category = self::getParam('category');
        $sort = self::getParam('sort');
        if (!is_null($level)) $query->andWhere(['level' => $level]);
        if (!is_null($category)) $query->andWhere(['like', 'category', $category . '%', false]);
        if (!is_null($sort)) $query->orderBy(['log_time' => SORT_ASC]);

        return $this->render('@csRoot/views/log', [
            'log' => [
                'dataProvider' => new ActiveDataProvider([
                    'query'      => $query,
                    'pagination' => [
                        'pageSize' => 100,
                    ],
                ]),
//                'filterModel'  => new \cs\modules\log\LogModel(),
                'columns'      => [
                    'id:text:id',
                    'level:text:level',
                    'category:text:category',
                    [
                        'label'   => 'date',
                        'contentOptions' => [
                            'nowrap' => 'nowrap',
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return \Yii::$app->formatter->asDate((int)$model['log_time']);
                        }
                    ],
                    [
                        'label'   => 'time',
                        'contentOptions' => [
                            'nowrap' => 'nowrap',
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            $isViewMilliseconds = true;

                            $suffix = '';
                            if ($isViewMilliseconds) {
                                $decimal = $model['log_time'] - (int)$model['log_time'];
                                $suffix = substr($decimal, 1, 4);
                            }
                            return \Yii::$app->formatter->asTime((int)$model['log_time']) . $suffix;
                        }
                    ],
                    [
                        'label'   => 'ip',
                        'contentOptions' => [
                            'nowrap' => 'nowrap',
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            $array = LogController::parseString($model['prefix']);
                            return $array[0];
                        }
                    ],
                    [
                        'label'   => 'user_id',
                        'contentOptions' => [
                            'nowrap' => 'nowrap',
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            $array = LogController::parseString($model['prefix']);
                            return $array[1];
                        }
                    ],
                    [
                        'label'   => 'unknown',
                        'contentOptions' => [
                            'nowrap' => 'nowrap',
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            $array = LogController::parseString($model['prefix']);
                            return $array[2];
                        }
                    ],
                    [
                        'label'   => 'message',
                        'content' => function ($model, $key, $index, $column) {
                            return Html::tag('pre', Html::encode($model['message']));
                        }
                    ],
                ]
            ]
        ]);
    }

} 
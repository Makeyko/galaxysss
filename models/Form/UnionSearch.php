<?php

namespace app\models\Form;

use app\models\Form\Stock;
use app\models\User;
use cs\services\Str;
use cs\services\VarDumper;
use Yii;
use yii\base\Model;
use cs\Widget\FileUpload2\FileUpload;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Html;

/**
 * ContactForm is the model behind the contact form.
 */
class UnionSearch extends Union
{

    public function rules()
    {
        return [
            [
                ['name'], 'default'
            ]
        ];
    }

    public function search($params)
    {
        $query = \app\models\Union::query(['in','moderation_status', [0, 1]])
            ->orderBy(['date_insert' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}

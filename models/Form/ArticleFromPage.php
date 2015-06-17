<?php

namespace app\models\Form;

use app\models\Article;
use app\models\Union;
use app\models\User;
use cs\base\BaseForm;
use cs\services\BitMask;
use cs\services\File;
use cs\services\Str;
use cs\services\Url;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\Model;
use cs\Widget\FileUpload2\FileUpload;
use yii\db\Query;

/**
 * ContactForm is the model behind the contact form.
 */
class ArticleFromPage extends BaseForm
{
    const TABLE = 'gs_article_list';

    public $id;
    public $url;
    public $provider;
    public $tree_node_id_mask;

    public function rules()
    {
        return [
            [
                [
                    'url',
                ],
                'required',
                'message' => 'Поле должно быть заполнено обязательно'
            ],
            [
                [
                    'url',
                ],
                'url',
            ],
            [
                [
                    'provider',
                ],
                'string',
            ],
            [
                [
                    'tree_node_id_mask',
                ],
                'cs\Widget\CheckBoxListMask\Validator',
            ],
        ];
    }

    public function insert()
    {
        /** @var \app\services\GetArticle\ExtractorInterface $extractor */
        $extractor = null;
        switch ($this->provider) {
            case 'verhosvet':
                $extractor = new \app\services\GetArticle\Verhosvet($this->url);
                break;
            case 'youtube':
                $extractor = new \app\services\GetArticle\YouTube($this->url);
                break;
        }
        if (is_null($extractor)) {
            throw new Exception('Не верный extractor');
        }
        $row = $extractor->extract();
        $articleObject = Article::insert([
            'header'            => $row['header'],
            'content'           => $row['content'],
            'description'       => $row['description'],
            'source'            => $this->url,
            'id_string'         => Str::rus2translit($row['header']),
            'date_insert'       => gmdate('YmdHis'),
            'tree_node_id_mask' => (new BitMask($this->tree_node_id_mask))->getMask(),
        ]);
        $this->id = $articleObject->getId();
        $image = $row['image'];
        $imageContent = file_get_contents($image);
        $imageUrl = parse_url($image);
        $pathInfo = pathinfo($imageUrl['path']);
        $pathInfo['extension'];
        $fields = \cs\Widget\FileUpload2\FileUpload::save(File::content($imageContent), $pathInfo['extension'], [
            'image',
            'Картинка',
            0,
            'string',
            'widget' => [
                FileUpload::className(),
                [
                    'options' => [
                        'small' => \app\services\GsssHtml::$formatIcon
                    ]
                ]
            ]
        ], $this);
        $articleObject->update($fields);

        return true;
    }
}

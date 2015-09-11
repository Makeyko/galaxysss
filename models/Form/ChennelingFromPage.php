<?php

namespace app\models\Form;

use app\models\Article;
use app\models\Chenneling;
use app\models\Union;
use app\models\User;
use app\services\GetArticle\Collection;
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
class ChennelingFromPage extends BaseForm
{
    const TABLE = 'gs_cheneling_list';

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

    public function insert($fieldsCols = NULL)
    {
        $extractorConfig = Collection::find($this->provider);
        if (is_null($extractorConfig)) {
            throw new Exception('Не верный extractor');
        }
        $extractorClass = $extractorConfig['class'];
        /** @var \app\services\GetArticle\ExtractorInterface $extractor */
        $extractor = new $extractorClass($this->url);
        $articleObject = Chenneling::insertExtractorInterface($extractor);
        $articleObject->update([
            'tree_node_id_mask' => (new BitMask($this->tree_node_id_mask))->getMask(),
        ]);

        return true;
    }
}

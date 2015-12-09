<?php

namespace app\models\Form\Shop;

use app\models\Form\Shop;
use app\models\NewsItem;
use app\models\Shop\Request;
use app\models\User;
use app\modules\Shop\services\Basket;
use app\services\GsssHtml;
use cs\Application;
use cs\services\Str;
use cs\services\VarDumper;
use Yii;
use yii\base\Model;
use cs\Widget\FileUpload2\FileUpload;
use yii\db\Query;
use yii\helpers\Html;

/**
 * ContactForm is the model behind the contact form.
 */
class Order extends Model
{
    public $address;
    public $comment;

    public function rules()
    {
        return [
            [['address', 'comment'], 'string'],
        ];
    }

    /**
     * Создание заказа
     */
    public function add()
    {
        if (!$this->validate()) return false;

        // получаю список объединений в которые надо отправлять заказ
        $unionList = Basket::getUnionIds();
        foreach ($unionList as $unionId) {
            $shop = \app\models\Shop::find(['union_id' => $unionId]);
            $productList = Basket::get($unionId);
            $request = Request::add([
                'address'  => $this->address,
                'union_id' => $unionId,
                'status'   => Request::STATUS_SEND_TO_SHOP,
                'comment'  => $this->comment,
            ], $productList);
            // письмо магазину
            Application::mail($shop->getField('admin_email'), 'Заказ #' . $request->getId(), 'shop/request_shop', [
                'request' => $request,
            ]);
            // письмо клиенту
            Application::mail(Yii::$app->user->identity->getEmail(), 'Заказ #' . $request->getId(), 'shop/request_client', [
                'request' => $request,
            ]);
        }
        Basket::clear();

        return true;
    }
}

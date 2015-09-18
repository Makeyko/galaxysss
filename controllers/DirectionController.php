<?php

namespace app\controllers;

use app\models\Form\Event;
use app\models\HD;
use app\models\HDtown;
use app\models\Log;
use app\models\SiteUpdate;
use app\models\User;
use app\services\GetArticle\YouTube;
use app\services\GraphExporter;
use app\services\HumanDesign2;
use cs\base\BaseController;
use cs\helpers\Html;
use cs\services\SitePath;
use cs\services\Str;
use cs\services\VarDumper;
use Yii;
use yii\base\Exception;
use yii\base\UserException;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\services\RegistrationDispatcher;

class DirectionController extends BaseController
{
    public $layout = 'menu';

    public function actionIndex()
    {
        return $this->render();
    }
}

<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Условия наблюдения и пользования Инструментом Вознесения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>

        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <p class="text-center"><img src="/images/site/conditions/holo.png" style="max-width: 400px; width: 100%;"></p>

                <p class="lead" style="text-align: justify">
                    Наблюдая эту мандалу вы получаете многомерное знание альтернативного развития и эволюции человечества
                    направленное на Центральное Солнце Вселенной, которое говорит об объединении, синтезе, балансе мужских и
                    женских энергий Вселенной и расположение их в соответствии с Божественным Замыслом Золотого Века Творца,
                    где каждый атом вибрирует РАдостью и скрепляется Любовью, в самом центре России установлен символ
                    изобилия – бесконечный Источник Энергии (<a
                        href="http://teslagen.org/news/2015/10/24/zapuschena_razrabotka_novogo_k"
                        target="_blank"
                        >ТеслаГен</a>) полностью
                    замещающий и нейтрализирующий все негативные действия и последствия действий <a
                        href="http://tainy.net/12607-zikkurat-v-centre-moskvy.html"
                        target="_blank">Зикурата</a> и создании на
                    планете Земля мира <a href="http://www.i-am-avatar.com/">Богов СоТворцов Эры Водолея</a>.
                </p>

                <p class="lead" style="text-align: justify">
                    Обладая свободой воли вы имеете право на свободу выбора своего развития и принимаете решение на основе
                    своей осознанности и неприкосновенности воли как «Я Есмь Творец и желаю всем Счастья».
                </p>

                <p>
                    Эта мандала была специально разработана для прохождения Зведных Врат 11.11 (<a
                        href="http://www.galaxysss.ru/chenneling/2015/10/18/svyaschennyy_soyuz_vozvraschen">статья 1</a> и
                    <a href="http://www.galaxysss.ru/chenneling/2015/11/07/svyaschennyy_soyuz_i_bozhestve">статья 2</a>).
                    Они состоялись 11 ноября 2015 г. которые стали началом новой Эры Водоления и Новой Реальности и <a
                        href="<?= \yii\helpers\Url::to(['new_earth/index']) ?>">Новой Земли</a>.
                </p>

                <hr>
                <p class="text-center"
                    ><img class=""
                          src="/images/site/conditions/Tesla-Gen-logo1-copy-5.jpg" style="max-width: 400px; width: 100%;"></p>
                <hr>
                <p class="text-center"><a href="http://www.i-am-avatar.com/" target="_blank" class="btn btn-primary">www.i-am-avatar.com</a>
                </p>

                <p class="text-center">В скором времени сайт откроется, на котором будет рассказано
                    как каждый желающий может себе вернуть все атрибуты божественного существа (аватара) и вспомнить себя
                    как Творца Нового Мира.
                    Также мы расскажем вам о способностях Аватара в
                    новом фильме <a href="https://ru.wikipedia.org/wiki/%D0%90%D0%B2%D0%B0%D1%82%D0%B0%D1%80_2">Аватар 2</a>.
                </p>

                <hr>
                <?= $this->render('../blocks/share', [
                    'image'       => \yii\helpers\Url::to('/images/site/conditions/holo.png', true),
                    'url'         => \yii\helpers\Url::current([], true),
                    'title'       => 'Условия наблюдения и пользования Инструментом Вознесения',
                    'description' => 'Наблюдая эту мандалу вы получаете многомерное знание альтернативного развития и эволюции человечества направленное на Центральное Солнце Вселенной, которое говорит об объединении, синтезе, балансе  мужских и женских энергий Вселенной и расположение их в соответствии с Божественным Замыслом Золотого Века Творца, где каждый атом вибрирует РАдостью и скрепляется Любовью, в самом центре России установлен символ изобилия – бесконечный Источник Энергии (ТеслаГен) полностью замещающий и нейтрализирующий все негативные действия и последствия действий Зикурата и создании на планете Земля мира Богов СоТворцов Эры Водолея.',
                ]) ?>
            </div>
        </div>
    </div>


</div>

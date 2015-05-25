<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\User;
use yii\grid\GridView;
use app\models\Form\Bank as FormBank;
use cs\Widget\FileUpload\FileUpload;
use Imagine\Image\ManipulatorInterface;

/* @var $this yii\web\View */
/* @var $user cs\models\Client */

if (isset($error)) {
    echo $error;

    return;
}


$fields = [];
$widgetData = [
    'fields'  => $fields,
    'rows'    => [
        'name_first',
        [
            'attribute' => 'avatar',
            'content'   => function (\cs\models\Client $user) {
                return ($user->getAvatar(true) == '') ? '' : Html::img($user->getAvatar(true));
            },
        ]
    ],
    'exclude' => [],
];


/**
 * @param                   $widgetData
 * @param \cs\models\Client $user
 *
 */
function draw($widgetData, $user)
{
    $fields = $widgetData['fields'];
    $rows = $widgetData['rows'];
    $exclude = ArrayHelper::getValue($widgetData, 'exclude', []);
    $fieldsOff = [];
    foreach ($rows as $row) {
        if (is_string($row)) $fieldsOff[] = $row;
    }

    echo '<table class="table table-striped table-bordered detail-view">';
    echo '<tbody>';
    foreach ($rows as $row) {
        echo '<tr>';
        if (is_array($row)) {
            $label = ArrayHelper::getValue($row, 'label', '');
            if ($label != '') {
                $name = ArrayHelper::getValue($row, 'attribute', '');
                $field = getField($fields, $name);
                $label = $field[1];
            }
            $content = $row['content'];
            $value = call_user_func($content, $user);
        } else if (is_string($row)) {
            $name = $row;
            $field = getField($fields, $name);
            $label = $field[1];
            $value = $user->getField($name);
        }
        echo '<th>';
        echo $label;
        echo '</th>';

        echo '<td>';
        echo $value;
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}

function getField($fields, $name)
{
    foreach ($fields as $field) {
        if ($field[0] == $name) return $field;
    }
}

$this->title = 'Карточка клиента. ' . $user->getNameFirst();
$this->params['breadcrumbs'][] = $this->title;
function drawImage($value, $isLocalPath = false)
{
    if ($value == '') return '';

    return Html::a(
        Html::img($value, ['class' => 'thumbnail']),
        FileUpload::getOriginal($value, $isLocalPath),
        ['target' => '_blank']
    );
}

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-striped table-bordered detail-view">
        <tbody>
        <tr>
            <th width="300">Аватар</th>
            <td><?= drawImage($user->getAvatar(true)) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= Html::mailto($user->getEmail()) ?></td>
        </tr>
        <tr>
            <th>Имя</th>
            <td>Дмитрий</td>
        </tr>
        <tr>
            <th>Фамилия</th>
            <td>Мухортов</td>
        </tr>
        <tr>
            <th>Отчество</th>
            <td></td>
        </tr>
        <tr>
            <th>Телефон</th>
            <td><?= $user->getPhone() ?></td>
        </tr>
        <tr>
            <th>Пол</th>
            <td><?= $user->getGenderString() ?></td>
        </tr>
        <tr>
            <th>Статус</th>
            <td><?= $user->getStatusString() ?></td>
        </tr>
        <tr>
            <th>Местоположение</th>
            <td><?= (is_null($user->getPlace())) ? '' : $user->getPlace() ?></td>
        </tr>
        <tr>
            <th>Возраст</th>
            <td><?= (is_null($user->getAge())) ? '' : $user->getAge() ?></td>
        </tr>
        <tr>
            <th>Паспорт</th>
            <td><?= drawImage($user->getFilePassport(true)) ?></td>
        </tr>
        <tr>
            <th>Паспорт</th>
            <td>
                Серия: <?= $user->getField('file_passport_ser') ?><br>
                Номер: <?= $user->getField('file_passport_number') ?><br>
                Выдан кем: <?= $user->getField('file_passport_vidan_kem') ?><br>
                Выдан когда: <?= $user->getField('file_passport_vidan_kogda') ?><br>
                Адрес регистрации: <?= $user->getField('file_passport_registration_address') ?><br>
                Дата регистрации: <?= $user->getField('file_passport_registration_date') ?><br>
            </td>
        </tr>
        <tr>
            <th>Справка 2НДФЛ</th>
            <td><?= drawImage($user->getFile2ndfl(true)) ?></td>
        </tr>
        <tr>
            <th>Второй документ, удостоверяющий личность</th>
            <td><?= drawImage($user->getFilesSecondIdenty(true)) ?></td>
        </tr>
        <tr>
            <th>Документы, подтверждающие наличие первоначального взноса</th>
            <td><?= drawImage($user->getFilesConfirmationPayment(true)) ?></td>
        </tr>
        <tr>
            <th>Семейное положение</th>
            <td><?= $user->getMaritalStatusString() ?></td>
        </tr>
        <tr>
            <th>Есть дети?</th>
            <td><?= (is_null($user->getField('s_is_childrens'))) ? '' : (($user->getField('s_is_childrens') == 1)) ? 'Да' : 'Нет' ?></td>
        </tr>
        <tr>
            <th>Судимость?</th>
            <td><?= (is_null($user->getField('s_is_sud'))) ? '' : (($user->getField('s_is_sud') == 1)) ? 'Да' : 'Нет' ?></td>
        </tr>
        <tr>
            <th>Наличие неисполненных решений судебных органов?</th>
            <td><?= (is_null($user->getField('s_is_sud_neisp_resh'))) ? '' : (($user->getField('s_is_sud_neisp_resh') == 1)) ? 'Да' : 'Нет' ?></td>
        </tr>
        <tr>
            <th>Наличие против Вас судебных исков?</th>
            <td><?= (is_null($user->getField('s_is_sud_sud_isk'))) ? '' : (($user->getField('s_is_sud_sud_isk') == 1)) ? 'Да' : 'Нет' ?></td>
        </tr>
        <tr>
            <th>Работаете?</th>
            <td><?= (is_null($user->getField('s_is_work_now'))) ? '' : (($user->getField('s_is_work_now') == 1)) ? 'Да' : 'Нет' ?></td>
        </tr>
        <tr>
            <th>СНИЛС</th>
            <td><?= $user->getSnils() ?></td>
        </tr>
        <tr>
            <th>Авто</th>
            <td><?= $user->getField('s_auto') ?></td>
        </tr>
        <tr>
            <th>Есть материнский капитал?</th>
            <td><?= (is_null($user->isMatKapital())) ? '' : (($user->isMatKapital() == 1)) ? 'Да' : 'Нет' ?></td>
        </tr>
        <tr>
            <th>Сведения об имуществе</th>
            <td><?= $user->getField('i_info_imush') ?></td>
        </tr>
        <tr>
            <th>Созаемщики</th>
            <td><?= $user->getField('i_co_borrowers') ?></td>
        </tr>
        <tr>
            <th>Данные родственников</th>
            <td><?= $user->getField('i_rodnie_list') ?></td>
        </tr>
        <tr>
            <th>Проживание</th>
            <td><?= $user->getHomeTypeString() ?></td>
        </tr>
        </tbody>
    </table>
</div>

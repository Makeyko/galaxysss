<?php

namespace cs\models\Form;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\web\JsExpression;
use CreditSystem\App as CApplication;
use cs\Widget\FileUpload\FileUpload;
use cs\base\BaseForm;

/**
 *
 */
class User extends BaseForm
{
    use \cs\models\Fields\User;

    const TABLE        = 'cs_users';
    const TABLE_FIELDS = 'cs_users_fields';

    /** @var array $fields2 все названия полей таблицы cs_users_fields */
    public static $fields2;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return ArrayHelper::merge(self::rulesAdd(self::$fields), self::rulesAdd(self::$fields2), [
                [
                    'file_passport_number',
                    'validatePassportNum'
                ],
            ]);
    }

    /**
     * Проверка на такие же паспортные данные
     *
     * @param $attribute
     * @param $params
     */
    public function validatePassportNum($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $row = (new Query())
                ->select('user_id')
                ->from(self::TABLE_FIELDS)->where([
                    'file_passport_ser'    => $this->file_passport_ser,
                    'file_passport_number' => $this->file_passport_number,
                ])
                ->andWhere('user_id != :id', [':id' => \Yii::$app->user->identity->getId()])
                ->one();

            if ($row !== false) {
                $this->addError('file_passport_number', 'Такие паспортные данные уже существуют');
            }
        }
    }

    private function updateTable($tableName, $fieldsIn, $where)
    {
        $query = new Query();
        $command = $query->createCommand();
        $fields = [];
        foreach ($fieldsIn as $field) {
            $this->processUpdateField($fields, $field);
        }
        $command->update($tableName, $fields, $where)->execute();
    }

    /**
     * Обновляет запись в таблицу
     *
     * @return boolean результат операции
     */
    public function update($fieldsCols = NULL)
    {
        if ($this->validate()) {
            // cs_users
            if (!parent::update($fieldsCols)) return false;

            $query = new Query();
            $command = $query->createCommand();
            // cs_users_fields
            $fields = [];
            foreach (self::$fields2 as $field) {
                $this->processUpdateField($fields, $field);
            }
            if ((new Query())->select('*')->from(self::TABLE_FIELDS)->where(['user_id' => $this->id])->count() == 0) {
                $fields['user_id'] = $this->id;
                $command->insert(self::TABLE_FIELDS, $fields)->execute();
            }
            else {
                $command->update(self::TABLE_FIELDS, $fields, ['user_id' => $this->id])->execute();
            }

            return true;
        }

        return false;
    }

    /**
     * Конструктор
     */
    public function __construct($fields = [])
    {
        parent::__construct($fields);
        // date update
        $this->initDate(static::$fields2);
    }

    /**
     * Ищет запись в таблице
     *
     * @return \app\models\Form\User|null
     */
    public static function find($id)
    {
        $query = new Query();
        $row = $query->select('*')->from(self::TABLE)->where(['id' => $id])->one();
        $row2 = $query->select('*')->from(self::TABLE_FIELDS)->where(['user_id' => $id])->one();
        if (!$row2) {
            $row2 = [];
        }
        else {
            ArrayHelper::remove($row2, 'user_id');
        }
        if ($row) {
            return new static(ArrayHelper::merge($row, $row2));
        }
        else {
            return null;
        }
    }
}

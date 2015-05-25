<?php

namespace app\modules\Comment;

use app\services\UsersInCache;
use cs\services\Str;
use cs\services\VarDumper;
use Yii;
use yii\db\Query;
use yii\helpers\FileHelper;

/**
 * Class CommentCache
 *
 * Сервис для организации кеширования комментариев
 *
 * @package app\services
 */

class Cache extends \yii\base\Object
{
    /** @var  int идентификатор объекта для комментариев \app\models\Comment::TYPE_* */
    public $typeId;

    /** @var  int идентификатор строки */
    public $rowId;

    /** @var  string шаблон для комментариев */
    public $template;

    public $fields = 'noObject';

    const TABLE = 'gs_comments_cache';


    /**
     * Закеширована страница?
     */
    public function isCached()
    {
        return $this->getField('is_cached') == 1;
    }


    public function getField($name)
    {
        if (is_string($this->fields)) {
            $this->fields = (new Query())->select('*')->from(self::TABLE)->where([
                'type_id' => $this->typeId,
                'row_id'  => $this->rowId,
            ])->one();
        }
        if ($this->fields === false) {
            return null;
        }

        return $this->fields[$name];
    }

    /**
     * Получает закешированные данные
     * @return array
     *   [
     *   'html' => ''
     *   'ids' => []
     *   ]
     *
     */
    public function get()
    {
        $path = $this->getPath();
        if (!file_exists($path)) return '';
        $data = file_get_contents($path);
        $pos = Str::pos(';', $data);
        $idsString = Str::sub($data, 0, $pos);
        if ($idsString == '') {
            $ids = [];
        } else {
            $ids = explode(',', $idsString);
        }
        $html = Str::sub($data, $pos + 1);

        return [
            'ids'  => $ids,
            'html' => $html,
        ];
    }

    /**
     * @param callable $callbackGet
     *
     * @return string HTML
     */
    public function getExtended(\Closure $callbackGet)
    {
        if ($this->isCached()) {
            if ($this->isTemplateChanged() == false) {
                $data = $this->get();

                return $this->parseUsers($data);
            }
        }
        $data = $this->saveData($callbackGet);

        return $this->parseUsers($data);
    }

    /**
     * Парсит комментарии чтобы в них были аватарки и имена
     *
     * @param array $data
     *   [
     *   'html' => ''
     *   'ids' => []
     *   ]
     *
     * @return int
     */
    public function parseUsers($data)
    {
        $html = $data['html'];
        foreach($data['ids'] as $id) {
            $user = (new UsersInCache())->find($id);
            $html = str_replace('{user_'.$user['id'].'_id}',$user['id'],$html);
            $html = str_replace('{user_'.$user['id'].'_name}',$user['name'],$html);
            $html = str_replace('{user_'.$user['id'].'_avatar}',$user['avatar'],$html);
        }

        return $html;
    }

    /**
     * Вызывает $callbackGet для получения данных и сохраняет их в кеш
     *
     * @param \Closure $callbackGet
     *
     * @return string
     */
    public function saveData(\Closure $callbackGet)
    {
        $data = call_user_func($callbackGet, $this);
        $this->set($data);

        return $data;
    }

    /**
     * Возвращает время изменения шаблона для объекта
     * Если в БД не найдено то время будет взято от шаблона и сохранено в БД
     *
     * @return int|false
     */
    public function getTemplateModifyTime()
    {
        return $this->getField('template_modify_time');
    }

    /**
     * Берет время изменения файла шаблона и сохраняет его в БД
     */
    public function saveTemplateModifyTime()
    {
        $this->setTemplateModifyTime($this->_getTemplateModifyTime());
    }

    /**
     * Возвращает время изменения шаблона для объекта
     *
     * @return int
     */
    public function _getTemplateModifyTime()
    {
        return filemtime(Yii::getAlias($this->template));
    }

    /**
     * Сохраняет время изменения шаблона для объекта
     *
     * @param int $time
     *
     * @return false|int
     *
     */
    public function setTemplateModifyTime($time)
    {
        return (new Query())->createCommand()->update(self::TABLE, [
            'template_modify_time' => $time
        ])->execute();
    }

    /**
     * Сохраняет закешированные данные
     *
     * @param array $data
     *   [
     *   'html' => ''
     *   'ids' => []
     *   ]
     *
     * @return int
     */
    public function set($data)
    {
        $this->createFolder();
        $path = $this->getPath();
        $this->update([
            'is_cached'            => 1,
            'template_modify_time' => $this->_getTemplateModifyTime(),
        ]);
        $content = join(',', $data['ids']) . ';' . $data['html'];

        return file_put_contents($path, $content);
    }

    /**
     * Очищает кеш
     */
    public function clear()
    {
        $this->update(['is_cached' => 0]);
    }

    /**
     * Возвращает ответ на вопрос
     * Изменилось время изменения шаблона?
     *
     * @return bool
     */
    public function isTemplateChanged()
    {
        $time = $this->getTemplateModifyTime();
        if ($time == false) return true;

        return $time != $this->_getTemplateModifyTime();
    }

    /**
     * Возвращает полный путь к кешируемому файлу
     * @return string
     */
    private function getPath()
    {
        $typeIdString = self::getFolderName($this->typeId, 3);
        $rowIdString = self::getFolderName($this->rowId);
        $fileName = "@runtime/CommentCache/{$typeIdString}/{$rowIdString}.html";

        return Yii::getAlias($fileName);
    }

    private function update($data)
    {
        $this->save($data, [
            'type_id' => $this->typeId,
            'row_id'  => $this->rowId,
        ]);
    }

    private function save($set, $where)
    {
        if ((new Query())->select('*')->from(self::TABLE)->where($where)->exists()) {
            (new Query())->createCommand()->update(self::TABLE, $set, $where)->execute();
        }
        else {
            foreach ($set as $k => $v) {
                $where[ $k ] = $v;
            }
            (new Query())->createCommand()->insert(self::TABLE, $where)->execute();
        }
    }

    /**
     * Возвращает полный путь к кешируемому файлу
     * @return string
     */
    private function createFolder()
    {
        $typeIdString = self::getFolderName($this->typeId, 3);
        $fileName = "@runtime/CommentCache/{$typeIdString}";
        $path = Yii::getAlias($fileName);
        FileHelper::createDirectory($path);
    }

    /**
     * Создает имя папки
     * Если эти число то возвратит строку с числом и ведущими нулями длинной в общем = 8
     * Если это строка то она и будет возвращена
     *
     * @param int | string $id
     * @param int          $idLength
     *
     * @return string
     */
    private static function getFolderName($id, $idLength = 8)
    {
        $name = $id;
        if (is_numeric($id)) {
            $name = str_repeat('0', $idLength - strlen($id)) . $id;
        }

        return $name;
    }
}
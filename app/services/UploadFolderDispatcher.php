<?php

namespace cs\services;

use yii\helpers\FileHelper;

class UploadFolderDispatcher
{
    /**
     * @var string Задает путь к файлам загрузки относительно ккорня сайта
     *             начинается с '/' и не заканчивается '/'
     */
    protected static $uploadFolder = '/upload';

    /**
     * Создает папку в загрузочной папке
     * если указан параметр $id то будет создана подпапка
     *
     * @param string     $folder
     * @param int|str $id1
     * @param int|str $id2
     *
     * @return \cs\services\SitePath
     */
    public static function createFolder($folder, $id1 = null, $id2 = null, $id3 = null)
    {
        $path = new \cs\services\SitePath('/upload');
        $path->addAndCreate($folder);
        if (!is_null($id1)) {
            $path->addAndCreate(self::getFolderName($id1));
        }
        if (!is_null($id2)) {
            $path->addAndCreate(self::getFolderName($id2));
        }
        if (!is_null($id3)) {
            $path->addAndCreate(self::getFolderName($id3));
        }

        return $path;
    }

    /**
     * Создает имя папки
     * Если эти число то возвратит строку с числом и ведущими нулями длинной в общем = 8
     * Если это строка то она и будет возвращена
     *
     * @param int | str $id
     *
     * @return string
     */
    public static function getFolderName($id) {
        $idLength = 8;
        $name = $id;
        if (is_numeric($id)) {
            $name = str_repeat('0', $idLength - strlen($id)) . $id;
        }
        return $name;
    }

    /**
     * @param SitePath $folder
     * @param str $file
     */
    public function saveFile($folder, $file)
    {

    }


    /**
     * Создает имя файла {timeStamp}_{rand}.{ext}
     *
     * @param $file
     *
     * @return string
     *
     */
    public static function generateFileName($file)
    {
        $info = pathinfo($file);

        return time() . '_' . Security::generateRandomString(10) . '.' . strtolower($info['extension']);
    }
} 
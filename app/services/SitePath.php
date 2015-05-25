<?php

namespace cs\services;

use yii\helpers\FileHelper;

class SitePath
{
    /**
     * @var string путь к сайту например '/opt/var/www'
     */
    protected $basePath;

    /**
     * @var string $path путь относительно корня сайта '/upload/path'
     */
    protected $path;

    /**
     * @var string полный путь к папке/файлу, например '/opt/var/www/upload/path'
     */
    protected $pathFull;

    /**
     * @param string $path     путь относительно корня сайта
     */
    public function __construct($path)
    {
        $this->basePath = $_SERVER['DOCUMENT_ROOT'];
        $this->path = $path;
        $this->pathFull = FileHelper::normalizePath($this->basePath . $path);
    }

    /**
     * Прибавляет путь к папке
     *
     * @param string $folder папка которая прибавляется
     *                       может быть одним именем например 'folder'
     *                       может быть длинным именем например 'folder/subFolder/subFolder'
     *
     * @return SitePath
     */
    public function add($folder)
    {
        $this->path .= '/' . $folder;
        $this->pathFull = FileHelper::normalizePath($this->pathFull . '/' . $folder);

        return $this;
    }

    /**
     * Прибавляет путь к папке
     *
     * @param string $folder папка которая прибавляется
     *                       может быть одним именем например 'folder'
     *                       может быть длинным именем например 'folder/subFolder/subFolder'
     *
     * @return SitePath
     */
    public function addAndCreate($folder)
    {
        $this->add($folder);
        FileHelper::createDirectory($this->pathFull);

        return $this;
    }

    /**
     * Создает папку в текущем пути и возвращает новый объект этого класса с новым путем
     *
     * @param string $folder папка которая прибавляется
     *                       может быть одним именем например 'folder'
     *                       может быть длинным именем например 'folder/subFolder/subFolder'
     *
     * @return SitePath
     */
    public function create($folder)
    {
        $new = self::cloneObject($folder);
        FileHelper::createDirectory($new->pathFull);

        return $new;
    }

    /**
     * Клонирует себя в новый объект с тем же путем или добавочным `$path`
     *
     * @param string $path папка которая прибавляется
     *                     может быть одним именем например 'folder'
     *                     может быть длинным именем например 'folder/subFolder/subFolder'
     *
     * @return \cs\services\SitePath
     */
    public function cloneObject($path = '')
    {
        $new = new self($this->path);
        if ($path == '') return $new;

        return $new->add($path);
    }

    /**
     * Копирует этот отъект в место назначения ($destination)
     *
     * @param SitePath $destination место назначения
     *
     * @return SitePath место назначения
     */
    public function copyTo($destination)
    {
        if (is_dir($this->getPathFull())) {
            FileHelper::copyDirectory($this->getPathFull(), $destination->getPathFull());
        }
        if (is_file($this->getPathFull())) {
            copy($this->getPathFull(), $destination->getPathFull());
        }

        return $destination;
    }

    /**
     * Удаляет файл
     *
     * @param string $file   файл для удаления
     *                       может быть '', тогда считается что в текущем объекте указан файл
     *                       может быть одним именем например 'file'
     *                       может быть длинным именем например 'folder/subFolder/file'
     *
     * @return boolean unlink()
     *                 если файла не существует будет возвращено true
     */
    public function deleteFile($file = '')
    {
        $pathFull = $this->generate($file);
        if (file_exists($pathFull)) {
            return unlink($pathFull);
        }

        return true;
    }

    /**
     * Удаляет объект
     *
     * @param string $file   папка которая прибавляется
     *                       может быть '', тогда считается что в текущем объекте указан файл
     *                       может быть одним именем например 'file'
     *                       может быть длинным именем например 'folder/subFolder/file'
     *
     * @return boolean unlink()
     *                 если файла не существует будет возвращено true
     */
    public function delete($file = '')
    {
        $pathFull = $this->generate($file);
        if (is_dir($pathFull)) {
            FileHelper::removeDirectory($pathFull);

            return true;
        }
        if (is_file($pathFull)) {
            return unlink($pathFull);
        }
    }

    /**
     * Прибавляет к пути строку пути и возвращает нормализованный полный путь
     *
     * @param string $file   папка которая прибавляется
     *                       может быть ''
     *                       может быть одним именем например 'file'
     *                       может быть длинным именем например 'folder/subFolder/file'
     *
     * @return string
     */
    public function generate($file = '')
    {
        if ($file == '') return $this->pathFull;

        return FileHelper::normalizePath($this->pathFull . '/' . $file);
    }

    public function getPathFull()
    {
        return FileHelper::normalizePath($this->pathFull);
    }

    public function getPath()
    {
        return $this->path;
    }
}
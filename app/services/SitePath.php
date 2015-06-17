<?php

namespace cs\services;

use yii\helpers\FileHelper;

/**
 * Class SitePath
 *
 * Класс предназначен для пользования файлами которые находятся в пределах сайта
 * Нельзя использовать в параметрах класса '../'
 *
 * популярные функции:
 * exist()               Возвращает статус существования файла
 * read()                Возвращает содержимое файла
 * write($data)          Записывает данные в файл
 * getDirectory()        Возвращает родительскую директорию как строку
 * add($folder)          Прибавляет путь к папке
 * addAndCreate($folder) Прибавляет путь к папке и создает указанную в параметре папку
 * create($folder)       Создает папку в текущем пути и возвращает новый объект этого класса с новым путем
 * delete($file = '')    Удаляет объект
 * getPathFull()         Возвращает полный путь к файлу
 * getPath()             Возвращает относительный путь к файлу внутри сайта
 * getFileName()         Возврвщвет название файла
 * getExtension()        Возврвщвет расширение файла
 *
 * Инициализация:
 * ```php
 * $path = new SitePath('/upload/path');
 * ```
 *
 * @package Suffra\Service
 */
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
     * @var array массив возвращаемый функцией pathinfo()
     */
    protected $pathInfo;

    /**
     * @param string $path путь относительно корня сайта
     *
     * @throws \Exception
     */
    public function __construct($path)
    {
        if (Str::isContain($path, '..')) throw new \Exception('Нельзя в параметре передавать \'..\'');
        $this->basePath = $_SERVER['DOCUMENT_ROOT'];
        $this->path = $path;
        $this->pathFull = $this->basePath . $path;
    }

    /**
     * Проверяет есть ли в файловой системе такой файл
     *
     * @return bool
     */
    public function exist()
    {
        return file_exists($this->getPathFull());
    }

    /**
     * если это файл то читает
     * @return null | string
     * если файла не существует то возвращает null
     * если существует то возвращает его содержимое
     */
    public function read()
    {
        $pathFull = $this->getPathFull();
        if (!is_dir($pathFull)) {
            if (file_exists($pathFull)) {
                return file_get_contents($pathFull);
            }
        }

        return null;
    }

    /**
     * Записывает данные в файл. Если пути не существует то создает его
     *
     * @param string $data
     */
    public function write($data)
    {
        $pathFull = $this->getPathFull();
        $this->createDirectory($this->getDirectory());
        if (!is_dir($pathFull)) {
            file_put_contents($pathFull, $data);
        }
    }

    /**
     * Возвращает родительскую директорию как строку
     */
    public function getDirectory()
    {
        return dirname($this->getPathFull());
    }

    /**
     * Прибавляет путь к папке
     *
     * @param string | array $folder  папка которая прибавляется
     *                                может быть одним именем например 'folder'
     *                                может быть длинным именем например 'folder/subFolder/subFolder'
     *                                может быть массивом [int, int, string] идентификатор с ведущими нулями  первый параметр это идентификатор, вотрой количество знаков в конечной строке, третий - расширение (не обязательно)
     *
     * @return SitePath
     * @throws \Exception
     */
    public function add($folder)
    {
        $folder = self::convert($folder);

        $this->path .= '/' . $folder;
        $this->pathFull = $this->pathFull . DIRECTORY_SEPARATOR . $folder;

        return $this;
    }

    /**
     * Прибавляет путь к папке и создает указанную в параметре папку
     *
     * @param string | array $folder  папка которая прибавляется
     *                                может быть одним именем например 'folder'
     *                                может быть длинным именем например 'folder/subFolder/subFolder'
     *                                может быть массивом [int, int, string] идентификатор с ведущими нулями  первый параметр это идентификатор, вотрой количество знаков в конечной строке, третий - расширение (не обязательно)
     *
     * @return SitePath
     * @throws \Exception
     */
    public function addAndCreate($folder)
    {
        $folder = self::convert($folder);

        $this->add($folder);
        self::createDirectory($this->pathFull);

        return $this;
    }

    /**
     * Преобразовывает $folder как массив в строку
     *
     * @param $folder
     *
     * @return string
     * @throws \Exception
     */
    private static function convertArrayToName($folder)
    {
        $extension = '';
        if (isset($folder[2])) {
            $extension = $folder[2];
        }
        $folder = str_repeat('0', $folder[1] - strlen($folder[0])) . $folder[0];
        if ($extension != '') {
            $folder .= '.' . $extension;
        }

        return $folder;
    }

    /**
     * Проверка на входной параметр и превращение из массива в строку если надо
     *
     * @param $folder
     *
     * @return string
     * @throws \Exception
     */
    private static function convert($folder)
    {
        if (is_array($folder)) {
            $folder = self::convertArrayToName($folder);
        } else {
            if (Str::isContain($folder, '..')) throw new \Exception('Нельзя в параметре передавать \'..\'');
        }

        return $folder;
    }

    /**
     * Создает папку в текущем пути и возвращает новый объект этого класса с новым путем
     *
     * @param string $folder папка которая прибавляется
     *                       может быть одним именем например 'folder'
     *                       может быть длинным именем например 'folder/subFolder/subFolder'
     *
     * @return SitePath
     * @throws \Exception
     */
    public function create($folder)
    {
        $folder = self::convert($folder);

        $new = self::cloneObject($folder);
        self::createDirectory($new->pathFull);

        return $new;
    }

    /**
     * Клонирует себя в новый объект с тем же путем или добавочным `$path`
     *
     * @param string $path папка которая прибавляется
     *                     может быть одним именем например 'folder'
     *                     может быть длинным именем например 'folder/subFolder/subFolder'
     *
     * @return self
     * @throws \Exception
     */
    public function cloneObject($path = '')
    {
        $path = self::convert($path);
        $new = new self($this->path);
        if ($path == '') return $new;

        return $new->add($path);
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
     * @throws \Exception
     */
    public function deleteFile($file = '')
    {
        $file = self::convert($file);
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
     * @throws \Exception
     */
    public function delete($file = '')
    {
        $file = self::convert($file);
        $pathFull = $this->generate($file);
        if (is_dir($pathFull)) {
            self::removeDirectory($pathFull);

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
     * @throws \Exception
     */
    public function generate($file = '')
    {
        if ($file == '') return $this->pathFull;
        $file = self::convert($file);

        return $this->pathFull . DIRECTORY_SEPARATOR . $file;
    }

    public function getPathFull()
    {
        return $this->pathFull;
    }

    public function getPath()
    {
        return $this->path;
    }

    /**
     * Creates a new directory.
     *
     * This method is similar to the PHP `mkdir()` function except that
     * it uses `chmod()` to set the permission of the created directory
     * in order to avoid the impact of the `umask` setting.
     *
     * @param string  $path      path of the directory to be created.
     * @param integer $mode      the permission to be set for the created directory.
     * @param boolean $recursive whether to create parent directories if they do not exist.
     *
     * @return boolean whether the directory is created successfully
     * @throws \Exception if the directory could not be created.
     */
    private static function createDirectory($path, $mode = 0775, $recursive = true)
    {
        if (is_dir($path)) {
            return true;
        }
        $parentDir = dirname($path);
        if ($recursive && !is_dir($parentDir)) {
            static::createDirectory($parentDir, $mode, true);
        }
        try {
            $result = mkdir($path, $mode);
            chmod($path, $mode);
        } catch (\Exception $e) {
            throw new \Exception("Failed to create directory '$path': " . $e->getMessage(), $e->getCode(), $e);
        }

        return $result;
    }

    /**
     * Removes a directory (and all its content) recursively.
     *
     * @param string $dir     the directory to be deleted recursively.
     * @param array  $options options for directory remove. Valid options are:
     *
     * - traverseSymlinks: boolean, whether symlinks to the directories should be traversed too.
     *   Defaults to `false`, meaning the content of the symlinked directory would not be deleted.
     *   Only symlink would be removed in that default case.
     */
    private static function removeDirectory($dir, $options = [])
    {
        if (!is_dir($dir)) {
            return;
        }
        if (isset($options['traverseSymlinks']) && $options['traverseSymlinks'] || !is_link($dir)) {
            if (!($handle = opendir($dir))) {
                return;
            }
            while (($file = readdir($handle)) !== false) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                $path = $dir . DIRECTORY_SEPARATOR . $file;
                if (is_dir($path)) {
                    static::removeDirectory($path, $options);
                }
                else {
                    unlink($path);
                }
            }
            closedir($handle);
        }
        if (is_link($dir)) {
            unlink($dir);
        }
        else {
            rmdir($dir);
        }
    }

    /**
     * Возврвщвет название файла
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->getPathInfo('basename');
    }

    /**
     * Возврвщвет расширение файла
     * Если раширения нет то будет возвращено null
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->getPathInfo('extension');
    }

    /**
     * Возвращает параметр функции pathinfo()
     *
     * @param string $name
     *
     * @return string
     */
    public function getPathInfo($name = null)
    {
        if (is_null($this->pathInfo)) {
            $this->pathInfo = pathinfo($this->getPath());
        }

        if (is_null($name)) {
            return $this->pathInfo;
        }

        return $this->pathInfo[ $name ];
    }

    /**
     * @param self   $folder
     * @param string $fileName новое название файла, по умолчанию берется имя из себя
     *
     * @return self файл назначения
     * @throws \Exception
     */
    public function copyToFolder($folder, $fileName = null)
    {
        if (is_null($fileName)) {
            $fileName = $this->getFileName();
        }
        $ret = $folder->cloneObject();
        $ret->add($fileName);
        @copy($this->getPathFull(), $ret->getPathFull());

        return $ret;
    }
}
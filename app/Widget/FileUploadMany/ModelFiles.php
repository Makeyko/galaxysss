<?php


namespace cs\Widget\FileUploadMany;

use cs\services\SitePath;

class ModelFiles extends \cs\base\DbRecord
{
    const TABLE = 'widget_uploader_many';

    /**
     * Возвращает полный путь к файлу
     *
     * @return string
     */
    public function getPathFull()
    {
        return (new SitePath($this->getField('file_path')))->getPathFull();
    }

    /**
     * Возвращает путь к файлу относительно корня сайта
     *
     * @return string
     */
    public function getPath()
    {
        $val = $this->getField('file_path');
        if (is_null($val)) return '';

        return $val;
    }

    /**
     * Возвращает название файла
     *
     * @return string
     */
    public function getFileName()
    {
        $val = $this->getField('file_name');
        if (is_null($val)) return '';

        return $val;
    }

    /**
     * Возвращает ссылку для скачивания файла
     *
     * @return string
     */
    public function getDownloadLink()
    {
        return FileUploadMany::getDownloadLink($this->getId());
    }
}
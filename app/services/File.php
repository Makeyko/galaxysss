<?php


namespace cs\services;


class File
{
    /** @var  string путь к файлу полный */
    public $path;
    public $content;

    public static function content($content)
    {
        $item = new self();
        $item->content = $content;

        return $item;
    }

    public static function path($path)
    {
        $item = new self();
        $item->path = $path;

        return $item;
    }

    public function isContent()
    {
        return !is_null($this->content);
    }

    public function isPath()
    {
        return !is_null($this->content);
    }

    /**
     * @param string $path полный путь куда сохраняется
     */
    public function save($path)
    {
        if ($this->isContent()) {
            file_put_contents($path, $this->content);
            return;
        }
        copy($this->path, $path);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: prog3
 * Date: 21.05.15
 * Time: 18:19
 */

namespace app\services\GetArticle;


interface ExtractorInterface
{
    /**
     * Возвращает информацию о статье
     *
     * @return array
     * [
     *     'image'       => $this->getImage(),
     *     'header'      => $this->getHeader(),
     *     'content'     => $this->getContent(),
     *     'description' => $this->getDescription(),
     * ];
     */
    public function extract();

    /**
     * Возвращает содержимое для поля content
     * @return string HTML
     */
    public function getContent();

    /**
     * Возвращает название статьи
     *
     * @return string
     */
    public function getHeader();

    /**
     * Возвращает картинку для статьи
     * Если картинки нет то будет возвращено null
     *
     * @return string | null
     */
    public function getImage();

    /**
     * Возвращает описание
     *
     * @return string
     */
    public function getDescription();

} 
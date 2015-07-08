<?php
/**
 * Интерфейс для материала сайта
 */

namespace app\models;


interface SiteContentInterface
{

    /**
     * Генерирует письмо для рассылки обновления
     *
     * @return SubscribeItem
     */
    public function getMailContent();


    /**
     * Генерирует данные для таблицы обновлений сайта
     *
     * @param bool $isScheme надо ли добавлять полный путь
     *
     * @return SiteUpdateItem
     */
    public function getSiteUpdateItem($isScheme = false);

} 
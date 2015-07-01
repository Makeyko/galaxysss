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
} 
<?php


namespace app\services\investigator;


/**
 * Следователь за новыми посланиями
 *
 * Этот интерфейс предоставляет набор функций которые дают возможность следить за новыми обновлениями на
 * страницах сайтов
 * в рассылках
 * в RSS лентах
 *
 * Interface InvestigatorInterface
 *
 * @package app\services\investigator
 */

interface InvestigatorInterface
{
    /**
     * Возвращает элементы которые есть
     *
     * @return array
     * [
     *    'url' => str
     * ]
     */
    public function getItems();

    /**
     * Возвращает новые элементы
     *
     * @return array
     * [
     *
     * ]
     */
    public function getNewItems();

    /**
     * Возвращает статью по идентификатору
     *
     * @param string $id идентификатор статьи
     *
     * @return array
     */
    public function getItem($id);
} 
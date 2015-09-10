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
 * Все данные хранятся в таблице gs_investigator
 * id - идентификатор
 * class_name - название класса который занимается обслуживанием обновлений
 * url - URL статьи
 * status - статус статьи (1 - пропущена, 2 - добавлена)
 * date_insert - время добавления
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
     * [[
     *     'name'
     *     'url'
     * ],...]
     */
    public function getItems();

    /**
     * Возвращает новые элементы
     *
     * @return array
     * [[
     *     'name'
     *     'url'
     * ],...]
     */
    public function getNewItems();

    /**
     * Возвращает статью по идентификатору
     *
     * @param string $url идентификатор статьи
     *
     * @return array
     * [
     *    'url'
     *    'image'       => $this->getImage(),
     *    'header'      => $this->getHeader(),
     *    'content'     => $this->getContent(),
     *    'description' => $this->getDescription(),
     * ]
     */
    public function getItem($url);
} 
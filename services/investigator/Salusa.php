<?php

namespace app\services\investigator;


class Salusa implements InvestigatorInterface
{
    /** @var string ссылка где публикуются обновления */
    public $url = 'http://chenneling.net/tag/poslanie-salusa-s-siriusa';

    /** @var int идентификатор фильтра в таблице gs_channeling_investigator */
    public $id = 1;

    public function getItems()
    {

    }

    public function getNewItems()
    {

    }

    public function getItem($id)
    {

    }
} 
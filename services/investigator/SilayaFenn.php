<?php

namespace app\services\investigator;


use app\models\Investigator;
use app\services\GetArticle\Chenneling;
use cs\services\VarDumper;

class SilayaFenn extends SiteChennelingNet implements InvestigatorInterface
{
    /** @var string ссылка где публикуются обновления */
    public $url = 'http://chenneling.net/tag/siliya-fenn';

    /** @var int идентификатор фильтра в таблице gs_channeling_investigator */
    public $id = 2;
}
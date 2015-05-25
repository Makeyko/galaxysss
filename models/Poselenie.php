<?php


namespace app\models;


class Poselenie extends \cs\base\DbRecord
{
    const TABLE = 'gs_posoleniya';

    public function incViewCounter()
    {
        $this->update(['view_counter' => $this->getField('view_counter') + 1]);
    }
} 
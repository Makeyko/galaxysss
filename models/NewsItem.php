<?php


namespace app\models;


class NewsItem extends \cs\base\DbRecord
{
    const TABLE = 'gs_news';

    public function incViewCounter()
    {
        $this->update(['view_counter' => $this->getField('view_counter') + 1]);
    }
} 
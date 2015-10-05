<?php

namespace app\models;


class Investigator extends \cs\base\DbRecord
{
    const TABLE = 'gs_investigator';

    const STATUS_SKIP = 1;
    const STATUS_ADD  = 2;
    const STATUS_NEW  = 3;
}
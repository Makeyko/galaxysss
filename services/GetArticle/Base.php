<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 11.09.2015
 * Time: 1:53
 */

namespace app\services\GetArticle;

use cs\services\Str;
use cs\services\Url;
use cs\services\VarDumper;

class Base
{
    /** @var  string */
    public $url;

    /** @var  \simple_html_dom */
    private $document;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getDocument()
    {
        if (is_null($this->document)) {
            $this->document = $this->_getDocument();
        }

        return $this->document;
    }

    public function _getDocument()
    {
        require_once(\Yii::getAlias('@csRoot/services/simplehtmldom_1_5/simple_html_dom.php'));
        $url = $this->url;
        $url = new Url($url);
        if (strtolower($url->scheme) == 'https') {
            $url->scheme = 'http';
        }
        $url = $url->__toString();
        $body = file_get_contents($url);

        return str_get_html($body);
    }

} 
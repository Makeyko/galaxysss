<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 11.09.2015
 * Time: 1:53
 */

namespace app\services\GetArticle;

use cs\services\Security;
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

//        $url = new Url($this->url);
//        if (strtolower($url->scheme) == 'https') {
//            $url->scheme = 'http';
//        }
//        $url = $url->__toString();
//        $body = file_get_contents($url);
        $curl = curl_init($this->url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: windows-1251']);
        $body = curl_exec($curl);

        $result = new \StdClass();
        $result->status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result->body = $body;
        curl_close($curl);
        $d = new \cs\services\SitePath('/upload');
        $d->addAndCreate('test2');
        $d->add(time().'_'.Security::generateRandomString().'.txt')->write($body);
        \Yii::info($body, 'gs\\inv');

        if ($result->status_code != 200) {
            throw new \cs\web\Exception('Не удалось прочитать файл');
        }

        return str_get_html($body);
    }

} 
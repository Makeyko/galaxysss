<?php

namespace app\services;
use cs\services\VarDumper;

/**
 * Получает картинку для Дизайна Человека
 *
 * Class HumanDesign
 *
 * @package app\services
 *
 */
class HumanDesign
{
    public $url = 'http://jovianarchive.com/Get_Your_Chart';

    public static $countryList = [];
    public static $townList    = [];

    /**
     * @param string $datetime 'yyyy-mm-dd HH:mm'
     * @param string $country
     * @param string $town
     *
     * @return string
     */
    public function calc($datetime, $country, $town)
    {
        $options = [
            'IsVariableChart' => 'False',
            'Day'             => substr($datetime, 8, 2),
            'Month'           => substr($datetime, 5, 2),
            'Year'            => substr($datetime, 0, 4),
            'Hour'            => substr($datetime, 11, 2),
            'Minute'          => substr($datetime, 14, 2),
            'Country'         => $country,
            'City'            => $town,
        ];
        $curl = curl_init($this->url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36');
        curl_setopt($curl, CURLOPT_POST, 1);
        $query = http_build_query($options);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        $body = curl_exec($curl);

        $result = new \StdClass();
        $result->status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result->body = $body;
        curl_close($curl);

        return $this->getImageUrlFromHtml($result->body);
    }

    /**
     * Получает info дизайна
     *
     * @param $html
     *
     * @return array
     * [
     *    'image' => string
     *    'Type' => string
     *    'Profile' => string
     *    'Definition' => string
     *    'Inner' => string
     *    'Strategy' => string
     *    'Theme' => string
     *    'Cross' => string
     * ]
     */
    private function getImageUrlFromHtml($html)
    {
        require_once(\Yii::getAlias('@csRoot/services/simplehtmldom_1_5/simple_html_dom.php'));

        $doc = str_get_html($html);
        $content = $doc->find('.page_content/.single_column')[0];
        $table = $content->find('table')[0];
        $img = $content->find('img')[0];
        $trList = $table->find('tr');
        $row1 = $trList[1]->find('td');
        $row2 = $trList[2]->find('td');
        $row3 = $trList[3]->find('td');
        $Type = trim(explode(':',trim($row1[0]->plaintext))[1]);
        $Profile = trim(explode(':',trim($row1[1]->plaintext))[1]);
        $Definition = trim(explode(':',trim($row1[2]->plaintext))[1]);

        $Inner = trim(explode(':',trim($row2[0]->plaintext))[1]);
        $Strategy = trim(explode(':',trim($row2[1]->plaintext))[1]);
        $Theme = trim(explode(':',trim($row2[2]->plaintext))[1]);
        $Cross = trim(explode(':',trim($row3[0]->plaintext))[1]);

        return [
            'image'      => 'http://jovianarchive.com' . $img->attr['src'],
            'Type'       => $Type,
            'Profile'    => $Profile,
            'Definition' => $Definition,
            'Inner'      => $Inner,
            'Strategy'   => $Strategy,
            'Theme'      => $Theme,
            'Cross'      => $Cross,
        ];
    }
} 
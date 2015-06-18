<?php

namespace cs\services;

use yii\helpers\ArrayHelper;

class Url
{
    public $params;
    public $scheme;
    public $query;
    public $host;
    public $path;

    /**
     * @param string $url
     * @param array  $params можно использовать вложенный массив, например если значение = ['a' => [1,2,4,'test' => 'value1', 'test2' => ['value2']]] то список параметров будет такой:
     * [
     *      'a[0]' => 1
     *      'a[1]' => 2
     *      'a[2]' => 4
     *      'a[test]' => 'value1'
     *      'a[test2][0]' => 'value2'
     * ]
     *
     */
    public function __construct($url = '', $params = [])
    {
        if ($url != '') {
            $s = parse_url($url);
            $this->scheme = $s['scheme'];
            if (isset($s['query'])) {
                $this->query = $s['query'];
                $q = explode('&', $s['query']);
                $arr = [];
                foreach ($q as $item) {
                    $arr2 = explode('=', $item);
                    $arr[ urldecode($arr2[0]) ] = urldecode($arr2[1]);
                }
                $this->params = ArrayHelper::merge($params, $arr);
            } else {
                $this->query = '';
                $this->params = $params;
            }
            $this->host = $s['host'];
            $this->path = $s['path'];
        }
    }

    /**
     * Добавляет переменную в запрос
     * @param string $name
     * @param string $value
     *
     * @return Url
     */
    public function addParam($name, $value)
    {
        $this->params[$name] = $value;

        return $this;
    }

    public function getParam($name, $default = '')
    {
        return ArrayHelper::getValue($this->params, $name, $default);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $arr = [];
        foreach ($this->params as $k => $v) {
            $ret = self::getParams($k, $v);
            foreach($ret as $k2 => $v2) {
                $arr[] = $k2 . '=' . urlencode($v2);
            }
        }
        if (count($arr) > 0) {
            $params = join('&', $arr);
        } else {
            $params = '';
        }
        if ($params != '') {
            return "{$this->scheme}://{$this->host}{$this->path}?{$params}";
        } else {
            return "{$this->scheme}://{$this->host}{$this->path}";
        }
    }

    /**
     * Возвращает список параметров url
     * Если $value является массивом, например $key = 'a' $value = [1,2,4,'test' => 'value1', 'test2' => ['value2']] то функция вернет
     * [
     *      'a[0]' => 1
     *      'a[1]' => 2
     *      'a[2]' => 4
     *      'a[test]' => 'value1'
     *      'a[test2][0]' => 'value2'
     * ]
     *
     * @param string           $key
     * @param array|string|int $value
     *
     * @return array
     */
    private static function getParams($key, $value)
    {
        $ret = [];
        if (is_array($value)) {
            foreach($value as $k => $v) {
                $ret2 = self::getParams($key. '[' . $k . ']', $v);
                foreach($ret2 as $k2 => $v2) {
                    $ret[$k2] = $v2;
                }
            }
        } else {
            $ret[$key] = $value;
        }

        return $ret;
    }
} 
<?php
/*
Класс Validator

$v = new Validator([
    'field1' => 'sadsa',
    'field2' => 5,
    'field3' => '23.12.1979',
    'field4' => 'dd dds ss',
]);
print_r($v->validate([
    [['field1'], 'string', ['min' => 1, 'max' => 4]],
    [['field2'], 'integer', ['min' => 1, 'max' => 6]],
    [['field3'], 'date', ['format' => 'd.m.Y', 'min' => '01.01.1980']],
    [['field3'], 'date', ['format' => 'd.m.Y', 'max' => 'now'], 'message' => 'должно быть не больше настоящего момента'],
    [['field4', 'field2'], 'required'],
    [['field4'], 'string', ['words' => 2]],
]));

*/


namespace cs\validators;

use Valitron\Validator as ValitronValidator;
use DateTime;

class Validator
{
    protected static $validator;

    public function __construct($params) {
        date_default_timezone_set('UTC');
        ValitronValidator::lang('ru');
        ValitronValidator::addRule('stringWords', function ($field, $value, array $params) {
            return (count(explode(' ', $value)) <= $params[0]);
        }, 'должно содержать не более слов: %s');
        self::$validator = new ValitronValidator($params);
    }

    /**
     * Проверяет REQUEST параметры используя Valitron\Validator
     *
     * @param $rules  array правила
     *
     * @return array errors if exist, if not exist return empty
     */
    public function validate($rules)
    {
        $posFieldName = 0;
        $posFieldRule = 1;
        $posFieldParams = 2;

        $v = static::$validator;
        foreach ($rules as $r) {
            $message = '';
            if (array_key_exists('message', $r)) {
                $message = '{field} ' . $r['message'];
                unset($r['message']);
            }
            switch ($r[ $posFieldRule ]) {
                case 'string':
                    if (count($r) == 2) {
//                        $v->rule('alphaNum', $r[ $posFieldName ]);
//                        if ($message != '') $v->message($message);
                    }
                    if (count($r) == 3) {
                        if (isset($r[ $posFieldParams ]['words'])) {
                            $this->setRule3_('stringWords', $r, 'words', $message);
                        }
                        if (isset($r[ $posFieldParams ]['min']) && isset($r[ $posFieldParams ]['max'])) {
                            $v->rule('lengthBetween', $r[ $posFieldName ], $r[ $posFieldParams ]['min'], $r[ $posFieldParams ]['max']);
                            if ($message != '') $v->message($message);
                        } else if (isset($r[ $posFieldParams ]['min'])) {
                            $this->setRule3_('lengthMin', $r, 'min', $message);
                        } else if (isset($r[ $posFieldParams ]['max'])) {
                            $this->setRule3_('lengthMax', $r, 'max', $message);
                        }
                    }
                    break;
                case 'integer':
                    if (count($r) == 2) {
                        $v->rule('integer', $r[ $posFieldName ]);
                        if ($message != '') $v->message($message);
                    }
                    if (count($r) == 3) {
                        if (isset($r[ $posFieldParams ]['min'])) {
                            $this->setRule3_('min', $r, 'min', $message);
                        }
                        if (isset($r[ $posFieldParams ]['max'])) {
                            $this->setRule3_('max', $r, 'max', $message);
                        }
                    }
                    break;
                case 'numeric':
                    if (count($r) == 2) {
                        $v->rule('numeric', $r[ $posFieldName ]);
                        if ($message != '') $v->message($message);
                    }
                    if (count($r) == 3) {
                        if (isset($r[ $posFieldParams ]['min'])) {
                            $this->setRule3_('min', $r, 'min', $message);
                        }
                        if (isset($r[ $posFieldParams ]['max'])) {
                            $this->setRule3_('max', $r, 'max', $message);
                        }
                    }
                    break;
                case 'date':
                    if ($r[ $posFieldRule ] == 'date') {
                        if (count($r) == 2) {
                            $v->rule('date', $r[ $posFieldName ]);
                            if ($message != '') $v->message($message);
                        }
                        if (count($r) == 3) {
                            if (isset($r[ $posFieldParams ]['format'])) {
                                $v->rule('dateFormat', $r[ $posFieldName ], $r[ $posFieldParams ]['format']);
                                if (isset($r[ $posFieldParams ]['min'])) {
                                    $v->rule('dateAfter', $r[ $posFieldName ], $this->validateDateFormat($r[ $posFieldParams ]['format'], $r[ $posFieldParams ]['min']));
                                    if ($message != '') $v->message($message);
                                }
                                if (isset($r[ $posFieldParams ]['max'])) {
                                    $v->rule('dateBefore', $r[ $posFieldName ], $this->validateDateFormat($r[ $posFieldParams ]['format'], $r[ $posFieldParams ]['max']));
                                    if ($message != '') $v->message($message);
                                }
                            } else {
                                if (isset($r[ $posFieldParams ]['min'])) {
                                    $this->setRule3_('dateAfter', $r, 'min', $message);
                                }
                                if (isset($r[ $posFieldParams ]['max'])) {
                                    $this->setRule3_('dateBefore', $r, 'max', $message);
                                }
                            }
                        }
                    }
                    break;
                default:
                    if (count($r) == 2) {
                        $this->setRule2($r, $message);
                    }
                    if (count($r) == 3) {
                        $this->setRule3($r, $message);
                    }
                    break;
            }
        }
        $v->validate();

        return $v->errors();
    }

    /*
     * @param array $r
     * @param string $message
     */
    private function setRule2($r, $message) {
        $posFieldName = 0;
        $posFieldRule = 1;
        $posFieldParams = 2;

        static::$validator->rule($r[ $posFieldRule ], $r[ $posFieldName ]);
        if ($message != '') static::$validator->message($message);
    }

    /*
     * @param array $r
     * @param string $message
     */
    private function setRule3($r, $message) {
        $posFieldName = 0;
        $posFieldRule = 1;
        $posFieldParams = 2;

        static::$validator->rule($r[ $posFieldRule ], $r[ $posFieldName ], $r[ $posFieldParams ]);
        if ($message != '') static::$validator->message($message);
    }

    /*
     * @param array $r
     * @param string $message
     */
    private function setRule3_($rule, $r, $paramName, $message)
    {
        $posFieldName = 0;
        $posFieldRule = 1;
        $posFieldParams = 2;

        static::$validator->rule($rule, $r[ $posFieldName ], $r[ $posFieldParams ][ $paramName ]);
        if ($message != '') static::$validator->message($message);
    }

    /**
     * преобразует строку даты $dateString заданную в формате $format в объект \DateTime
     *
     * @param string $format
     * @param string $dateString может быть задана как 'now' что значит сейчас
     * @param \DateTimeZone $timeZone
     *
     * @return \DateTime
     */
    private function validateDateFormat($format, $dateString, \DateTimeZone $timeZone = null)
    {
        if ($dateString == 'now') {
            return new DateTime();
        }
        if (is_null($timeZone)) {
            $timeZone = new DateTimeZone('UTC');
        }

        return DateTime::createFromFormat($format, $dateString, $timeZone);
    }
}

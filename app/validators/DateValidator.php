<?php

namespace cs\validators;

use IntlDateFormatter;
use Yii;
use DateTime;
use yii\helpers\FormatConverter;
use yii\helpers\VarDumper;
use yii\validators\Validator;

/**
 * Предназначен для использования в формах для проверки значений дат
 * Для начала использования необходимо подключить валидатор или в форме так:
 * public function __construct()
 * {
 *     \yii\validators\Validator::$builtInValidators['dateMinMax'] = 'cs\validators\DateValidator';
 * }
 * или в приложении так:
 *
 *
 * Использование в функции rules()
 * например [['field1'], 'dateMinMax', 'format' => 'php:d.m.Y', 'min' => '01.01.2000', 'max' => 'now']
 * если в параметре 'max' испольуется значение 'now' это означает что использовать момент настоящего в качестве значения
 * параметры 'min' и 'max' не обяательные
 *
 * @author Dmitrii Mukhortov <dram1008@yandex.ru>
 */
class DateValidator extends Validator
{
    /**
     * @var string the date format that the value being validated should follow.
     * This can be a date time pattern as described in the [ICU manual](http://userguide.icu-project.org/formatparse/datetime#TOC-Date-Time-Format-Syntax).
     *
     * Alternatively this can be a string prefixed with `php:` representing a format that can be recognized by the PHP Datetime class.
     * Please refer to <http://php.net/manual/en/datetime.createfromformat.php> on supported formats.
     *
     * If this property is not set, the default value will be obtained from `Yii::$app->formatter->dateFormat`, see [[\yii\i18n\Formatter::dateFormat]] for details.
     *
     * Here are some example values:
     *
     * ```php
     * 'MM/dd/yyyy' // date in ICU format
     * 'php:m/d/Y' // the same date in PHP format
     * ```
     */
    public $format;
    /**
     * @var string the locale ID that is used to localize the date parsing.
     * This is only effective when the [PHP intl extension](http://php.net/manual/en/book.intl.php) is installed.
     * If not set, the locale of the [[\yii\base\Application::formatter|formatter]] will be used.
     * See also [[\yii\i18n\Formatter::locale]].
     */
    public $locale;
    /**
     * @var string the timezone to use for parsing date and time values.
     * This can be any value that may be passed to [date_default_timezone_set()](http://www.php.net/manual/en/function.date-default-timezone-set.php)
     * e.g. `UTC`, `Europe/Berlin` or `America/Chicago`.
     * Refer to the [php manual](http://www.php.net/manual/en/timezones.php) for available timezones.
     * If this property is not set, [[\yii\base\Application::timeZone]] will be used.
     */
    public $timeZone;
    /**
     * @var string the name of the attribute to receive the parsing result.
     * When this property is not null and the validation is successful, the named attribute will
     * receive the parsing result.
     */
    public $timestampAttribute;
    /**
     * @var string верхняя граница даты для проверки, в формате $format
     */
    public $max;
    /**
     * @var string нижняя граница даты для проверки, в формате $format
     */
    public $min;
    /**
     * @var string сообщение если дата меньше $min
     */
    public $tooShort;
    /**
     * @var string сообщение если дата больше $max
     */
    public $tooLong;



    /**
     * @var array map of short format names to IntlDateFormatter constant values.
     */
    private $_dateFormats = [
        'short'  => 3, // IntlDateFormatter::SHORT,
        'medium' => 2, // IntlDateFormatter::MEDIUM,
        'long'   => 1, // IntlDateFormatter::LONG,
        'full'   => 0, // IntlDateFormatter::FULL,
    ];


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('yii', 'The format of {attribute} is invalid.');
        }
        if ($this->format === null) {
            $this->format = Yii::$app->formatter->dateFormat;
        }
        if ($this->locale === null) {
            $this->locale = Yii::$app->language;
        }
        if ($this->timeZone === null) {
            $this->timeZone = Yii::$app->timeZone;
        }
        if ($this->min !== null && $this->tooShort === null) {
            $this->tooShort = '{attribute} дата должна быть больше ' . $this->min;
        }
        if ($this->max !== null && $this->tooLong === null) {
            $this->tooLong = '{attribute} дата должна быть меньше ' . $this->max;
        }
    }

    /**
     * @param Form $object
     * @param string $attribute название поля
     */
    public function validateAttribute($object, $attribute)
    {
        $value = $object->$attribute;
        $ret = $this->validateValue($value);
        if ($ret === null) {
            if ($this->timestampAttribute !== null) {
                $object->{$this->timestampAttribute} = $this->parseDateValue($value);
            }
            return;
        }
        $this->addError($object, $attribute, $ret[0], $ret[1]);
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        $timeStamp = $this->parseDateValue($value);
        if ($timeStamp === false) {
            return [$this->message, []];
        }
        if ($this->min !== null && $timeStamp < $this->parseDateValue($this->min)) {
            return [$this->tooShort, ['min' => $this->min]];
        }
        if ($this->max !== null && $timeStamp > $this->parseDateValue($this->max)) {
            return [$this->tooLong, ['max' => $this->max]];
        }

        return null;
    }

    /**
     * Преобразует дату $value по формату $this->format в timestamp
     *
     * @param string $value
     *
     * @return false|integer
     * integer - если успешно
     * false - если не успешно
     */
    protected function parseDateValue($value)
    {
        if (is_array($value)) {
            return false;
        }
        if ($value == 'now') {
            return (new \DateTime())->getTimestamp();
        }
        $format = $this->format;
        if (strncmp($this->format, 'php:', 4) === 0) {
            $format = substr($format, 4);
        } else {
            if (extension_loaded('intl')) {
                if (isset($this->_dateFormats[$format])) {
                    $formatter = new IntlDateFormatter($this->locale, $this->_dateFormats[$format], IntlDateFormatter::NONE, $this->timeZone);
                } else {
                    $formatter = new IntlDateFormatter($this->locale, IntlDateFormatter::NONE, IntlDateFormatter::NONE, $this->timeZone, null, $format);
                }
                // enable strict parsing to avoid getting invalid date values
                $formatter->setLenient(false);
                return $formatter->parse($value);
            } else {
                // fallback to PHP if intl is not installed
                $format = FormatConverter::convertDateIcuToPhp($format, 'date');
            }
        }
        $date = DateTime::createFromFormat($format, $value, new \DateTimeZone($this->timeZone));
        $errors = DateTime::getLastErrors();
        if ($date === false || $errors['error_count'] || $errors['warning_count']) {
            return false;
        } else {
            // if no time was provided in the format string set time to 0 to get a simple date timestamp
            if (strpbrk($format, 'HhGgis') === false) {
                $date->setTime(0, 0, 0);
            }
            return $date->getTimestamp();
        }
    }
}

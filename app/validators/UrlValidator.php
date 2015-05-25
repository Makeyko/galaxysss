<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace cs\validators;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\JsExpression;
use yii\helpers\Json;

/**
 * UrlValidator validates that the attribute value is a valid http or https URL.
 *
 * Note that this validator only checks if the URL scheme and host part are correct.
 * It does not check the rest part of a URL.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class UrlValidator extends \yii\validators\UrlValidator
{
    /**
     * @var string the regular expression used to validate the attribute value.
     * The pattern may contain a `{schemes}` token that will be replaced
     * by a regular expression which represents the [[validSchemes]].
     */
    public $pattern = '/^({schemes}:\/\/)?(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)/i';
}

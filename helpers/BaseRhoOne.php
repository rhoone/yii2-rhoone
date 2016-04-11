<?php

/**
 *  _   __ __ _____ _____ ___  ____  _____
 * | | / // // ___//_  _//   ||  __||_   _|
 * | |/ // /(__  )  / / / /| || |     | |
 * |___//_//____/  /_/ /_/ |_||_|     |_|
 * @link https://vistart.name/
 * @copyright Copyright (c) 2016 vistart
 * @license https://vistart.name/license/
 */

namespace rhoone\helpers;

use Yii;

/**
 * Description of BaseRhoOne
 *
 * @author vistart <i@vistart.name>
 */
class BaseRhoOne
{

    const MESSAGE_CATEGORY = 'rhoone';

    public static function trace($message)
    {
        Yii::trace($message, self::MESSAGE_CATEGORY);
    }

    public static function warning($message)
    {
        Yii::warning($message, self::MESSAGE_CATEGORY);
    }

    public static function error($message)
    {
        Yii::error($message, self::MESSAGE_CATEGORY);
    }

    public static function info($message)
    {
        Yii::info($message, self::MESSAGE_CATEGORY);
    }
}

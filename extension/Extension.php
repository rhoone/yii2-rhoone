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

namespace rhoone\extension;

use yii\base\NotSupportedException;

/**
 * Description of Extension
 *
 * @author vistart <i@vistart.name>
 */
abstract class Extension extends \yii\base\Component
{

    public static function id()
    {
        throw new NotSupportedException('The extension\'s id has not been specified.');
    }

    public static function name()
    {
        throw new NotSupportedException('The extension\'s name has not been specified.');
    }

    /**
     * Get dictionary.
     * @return Dictionary
     */
    public static function getDictionary()
    {
        if (class_exists(__NAMESPACE__ . '\Dictionary')) {
            $class = __NAMESPACE__ . '\Dictionary';
            return new $class();
        }
        return null;
    }

    /**
     * 
     * @param string|string[] $keywords
     * @return boolean
     */
    public function match($keywords)
    {
        return false;
    }

    /**
     * Search, according to the keywords.
     * @param mixed $keywords
     * @return string search result.
     */
    abstract public function search($keywords);

    /**
     * Get module configuration array.
     * @return array module configuration array.
     */
    public static function getModule()
    {
        return null;
    }
}

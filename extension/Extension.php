<?php

/**
 *  _   __ __ _____ _____ ___  ____  _____
 * | | / // // ___//_  _//   ||  __||_   _|
 * | |/ // /(__  )  / / / /| || |     | |
 * |___//_//____/  /_/ /_/ |_||_|     |_|
 * @link https://vistart.me/
 * @copyright Copyright (c) 2016 - 2017 vistart
 * @license https://vistart.me/license/
 */

namespace rhoone\extension;

use yii\base\NotSupportedException;

/**
 * Description of Extension
 *
 * @author vistart <i@vistart.me>
 */
abstract class Extension extends \yii\base\Component
{

    /**
     * If you didn't implemented this method, the config array will be taken.
     * @throws NotSupportedException
     */
    public static function id()
    {
        throw new NotSupportedException('The extension\'s id has not been specified.');
    }

    /**
     * If you didn't implemented this method, the config array will be taken.
     * @throws NotSupportedException
     */
    public static function name()
    {
        throw new NotSupportedException('The extension\'s name has not been specified.');
    }

    /**
     * Configuration array example:
     * [
     *     'id' => <id>,           // Required.
     *     'name' => <name>,       // Required.
     *     'default' => false,      // Optional, Default to false.
     *     'monopolized' => false,  // Optional, Default to false.
     * ]
     * @return string|null
     */
    public static function config()
    {
        return null;
    }

    /**
     * Get dictionary.
     * @return Dictionary
     */
    public static function getDictionary()
    {
        if (class_exists(__NAMESPACE__ . '\Dictionary')) {
            $class = __NAMESPACE__ . '\Dictionary';
            if ($class == 'rhoone\extension\Dictionary') {
                return null;
            }
            return new $class();
        }
        return null;
    }

    /**
     * 
     * @param string|string[] $keywords
     * @return boolean|null
     */
    public function match($keywords)
    {
        return null;
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

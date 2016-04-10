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

use rhoone\models\Extension;
use yii\base\InvalidParamException;

/**
 * Description of ModuleHelper
 *
 * @author vistart <i@vistart.name>
 */
class ExtensionHelper
{

    public static function all()
    {
        return Extension::find()->all();
    }

    /**
     * Add extension.
     * @param string $class
     * @param boolean $enable
     * @return boolean
     * @throws InvalidParamException
     */
    public static function add($class, $enable = false)
    {
        if (!is_string($class)) {
            throw new InvalidParamException('the class name is not a string.');
        }

        if (!class_exists($class)) {
            throw new InvalidParamException('the class `' . $class . '` does not exist.');
        }

        $extension = new $class();

        if (!($extension instanceof \rhoone\extension\Extension)) {
            throw new InvalidParamException('the class `' . $class . '` is not an extension.');
        }
        
        $name = $extension->extensionName();

        if (Extension::find()->where(['classname' => $class])->exists()) {
            throw new InvalidParamException('the class `' . $class . '` has been added.');
        }
        
        $dic = $extension->getDictionaries();
        if (empty($dic)) {
            echo "Warning: This extension does not contain any dictionaries.\n";
        } else {
            
        }
        
        $extension = new Extension(['classname' => $class, 'name' => $name]);
        return $extension->save();
    }

    /**
     * Remove extension.
     * @param string $class
     * @param boolean $force
     * @return boolean
     * @throws InvalidParamException
     */
    public static function remove($class, $force)
    {
        $extension = Extension::find()->where(['classname' => $class])->one();
        if (!$extension) {
            throw new InvalidParamException('the class `' . $class . '` has not been added yet.');
        }
        return $extension->delete() == 1;
    }
}

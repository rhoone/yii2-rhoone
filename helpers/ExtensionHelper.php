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
        $extension = static::validate($class);

        $name = $extension->extensionName();

        $dic = $extension->getDictionaries();

        $extension = new Extension(['classname' => $extension->className(), 'name' => $name, 'enabled' => $enable == true]);
        return $extension->save();
    }

    /**
     * 
     * @param string $class
     * @return \rhoone\extension\Extension
     * @throws InvalidParamException
     */
    public static function validate($class)
    {
        if (!is_string($class)) {
            throw new InvalidParamException('the class name is not a string.');
        }
        
        if (!class_exists($class)) {
            if (strpos($class, "\\", strlen($class) - 1) === false) {
                $class .= "\Extension";
            } else {
                $class .= "Extension";
            }
        }
        if (!class_exists($class)) {
            throw new InvalidParamException('the class `' . $class . '` does not exist.');
        }

        $extension = new $class();
        $class = $extension->className();
        if (!($extension instanceof \rhoone\extension\Extension)) {
            throw new InvalidParamException('the class `' . $class . '` is not an extension.');
        }

        if (Extension::find()->where(['classname' => $class])->exists()) {
            throw new InvalidParamException('the class `' . $class . '` has been added.');
        }

        $dic = $extension->getDictionaries();
        if (empty($dic)) {
            echo "Warning: This extension does not contain any dictionaries.\n";
        } else {
            
        }
        return $extension;
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

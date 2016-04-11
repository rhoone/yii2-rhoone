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
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use Yii;

/**
 * Description of BaseExtensionHelper
 *
 * @author vistart <i@vistart.name>
 */
class BaseExtensionHelper
{

    public static function all()
    {
        return Extension::find()->all();
    }

    /**
     * 
     * @return \rhoone\extension\Extension[]
     */
    public static function allEnabled()
    {
        $exts = Extension::findAllEnabled();
        $extensions = [];
        foreach ($exts as $ext) {
            try {
                $extension = static::get($ext->classname);
            } catch (\Exception $ex) {
                Yii::error($ex->getMessage());
                continue;
            }
            $extensions[] = $extension;
        }
        return $extensions;
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

        unset($class);
        $class = $extension->className();
        $name = $extension->extensionName();

        if (Extension::find()->where(['classname' => $class])->exists()) {
            throw new InvalidParamException('the class `' . $class . '` has been added.');
        }

        $dic = $extension->getDictionaries();

        unset($extension);
        $extension = new Extension(['classname' => $class, 'name' => $name, 'enabled' => $enable == true]);
        return $extension->save();
    }

    /**
     * Enable extension.
     * @param string $class
     * @return boolean
     * @throws InvalidParamException
     * @throws InvalidConfigException
     */
    public static function enable($class)
    {
        $extension = static::validate($class);
        $enabledExt = Extension::find()->where(['classname' => $extension->className()])->one();
        if (!$enabledExt) {
            throw new InvalidParamException("`" . $extension->className() . "` has not been added yet.\n");
        }
        if ($enabledExt->isEnabled) {
            throw new InvalidParamException("`" . $extension->className() . "` has been enabled.\n");
        }
        $enabledExt->isEnabled = true;
        if (!$enabledExt->save()) {
            throw new InvalidConfigException("`" . $extension->className() . "` failed to enable.\n");
        }
        echo "`" . $extension->className() . "` is enabled.\n";
        return true;
    }

    /**
     * Get extension.
     * @param string $class
     * @return \rhoone\extension\Extension
     * @throws InvalidParamException
     */
    public static function get($class)
    {
        $extension = static::validate($class);
        $enabledExt = Extension::find()->where(['classname' => $extension->className()])->enabled(true)->one();
        if (!$enabledExt) {
            throw new InvalidParamException("`" . $extension->className() . "` has not been enabled.\n");
        }
        return $extension;
    }

    /**
     * Validate extension.
     * It will throw exception if error(s) occured.
     * @param string $class
     * @return \rhoone\extension\Extension
     * @throws InvalidParamException
     */
    public static function validate($class)
    {
        if (!is_string($class)) {
            Yii::error('the class name is not a string.', get_called_class() . '::' . 'validate');
            throw new InvalidParamException('the class name is not a string.');
        }
        Yii::trace('validate extension: `' . $class . '`', get_called_class() . '::' . 'validate');

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

        $dic = $extension->getDictionaries();
        if (empty($dic)) {
            Yii::warning("`$class` does not contain any dictionaries.\n", get_called_class() . '::' . 'validate');
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
        $extension = static::validate($class);
        unset($class);
        $class = $extension->className();
        unset($extension);
        $extension = Extension::find()->where(['classname' => $class])->one();
        if (!$extension) {
            throw new InvalidParamException('the class `' . $class . '` has not been added yet.');
        }
        return $extension->delete() == 1;
    }

    /**
     * 
     * @param mixed $keywords
     * @param mixed $extensions
     * @return \rhoone\extension\Extension[]
     */
    public static function match($keywords, $extensions = null)
    {
        $exts = static::allEnabled();
        foreach ($exts as $ext) {
            
        }
        return $exts;
    }

    /**
     * 
     * @param mixed $keywords
     * @param mixed $extensions
     * @return array
     */
    public static function search($keywords, $extensions = null)
    {
        $exts = static::match($keywords, $extensions);
        $results = [];
        foreach ($exts as $ext) {
            $results[] = $ext->search($keywords);
        }
        return $results;
    }
}

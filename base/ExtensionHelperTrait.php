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

namespace rhoone\base;

use Yii;
use yii\base\InvalidParamException;

/**
 * Description of ExtensionHelperTrait
 *
 * @author vistart <i@vistart.name>
 */
trait ExtensionHelperTrait
{

    /**
     * 
     * @param string $class
     */
    public static function register($class, $enable = false)
    {
        $extension = static::validate($class);
        if (static::getModel($extension)) {
            throw new InvalidParamException('the class `' . $extension->className() . '` has been added.');
        }
        $class = $extension->className();
        $name = $extension->name();
        $id = $extension->id();
        $dic = $extension->getDictionary();

        $model = new \rhoone\models\Extension(['id' => $id, 'name' => $name, 'classname' => $class, 'enabled' => $enable]);
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            if (!$model->save()) {
                throw new InvalidParamException('`' . $class . '` failed to added.');
            }
            if (!$model->addDictionary($dic)) {
                throw new InvalidParamException('`' . $class . '');
            }
            $transaction->commit();
        } catch (\Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }
        return true;
    }

    public static function enable($class)
    {
        $model = static::getModel($class);
        $model->isEnabled = true;
        return $model->save();
    }

    public static function disable($class)
    {
        $model = static::getModel($class);
        $model->isEnabled = false;
        return $model->save();
    }

    /**
     * 
     * @param string $class
     * @return string
     * @throws InvalidParamException
     */
    public static function normalizeClass($class)
    {
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
        return $class;
    }

    /**
     * 
     * @param string|\rhoone\extension\Extension|\rhoone\models\Extension $class
     * @return \rhoone\models\Extension
     */
    public static function getModel($class)
    {
        if ($class instanceof \rhoone\extension\Extension) {
            $class = $class->className();
        }
        if (is_string($class)) {
            return \rhoone\models\Extension::find()->where(['classname' => static::normalizeClass($class)])->one();
        }
        if ($class instanceof \rhoone\models\Extension) {
            return \rhoone\models\Extension::find()->guid($class->guid)->one();
        }
        return null;
    }

    /**
     * 
     * @param string|\rhoone\extension\Extension|\rhoone\models\Extension $class
     * @return boolean
     */
    public static function checkRegistered($class)
    {
        if ($class instanceof \rhoone\model\Extension) {
            return \rhoone\models\Extension::find()->guid($class->guid)->exists();
        }
        $extension = null;
        if (is_string($class)) {
            try {
                $extension = static::validate($class);
            } catch (\Exception $ex) {
                return false;
            }
        }
        if ($class instanceof \rhoone\extension\Extension) {
            $extension = $class;
        }
        return \rhoone\models\Extension::find()->where(['classname' => $extension->className()])->exists();
    }

    public static function checkEnabled($class)
    {
        $model = static::getModel($class);
        if (!$model) {
            return false;
        }
        return $model->isEnabled;
    }

    /**
     * 
     * @param \rhoone\extension\Extension|string $extension
     * @return \rhoone\extension\Extension
     * @throws InvalidParamException
     */
    public static function validateExtension($extension)
    {
        if (is_string($extension) && class_exists($extension)) {
            $extension = new $extension();
        }
        $class = $extension->className();
        if (!($extension instanceof \rhoone\extension\Extension)) {
            throw new InvalidParamException('the class `' . $class . '` is not an extension.');
        }
        return $extension;
    }

    /**
     * 
     * @param \rhoone\extension\Extension $extension
     * @return \rhoone\extension\Dictionary
     */
    public static function validateDictionary($extension)
    {
        $dic = $extension->getDictionary();
        $class = $extension->className();
        if (empty($dic) || !is_array($dic)) {
            Yii::warning("`$class` does not contain a dictionary.\n", __METHOD__);
        }
        return $dic;
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
            Yii::error('the class name is not a string.', __METHOD__);
            throw new InvalidParamException('the class name is not a string.');
        }
        Yii::trace('validate extension: `' . $class . '`', __METHOD__);

        $class = static::normalizeClass($class);
        $extension = static::validateExtension($class);
        $dic = static::validateDictionary($extension);
        return $extension;
    }

    /**
     * 
     * @param string $class
     */
    public static function deregister($class, $force = false)
    {
        $model = static::getModel($class);
        if ($model->isEnabled && !$force) {
            throw new InvalidParamException("Unable to remove the enabled extensions.");
        }
        return $model->delete() == 1;
    }
}

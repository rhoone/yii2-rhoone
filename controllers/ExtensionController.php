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

namespace rhoone\controllers;

use rhoone\models\Extension;
use Yii;
use yii\console\Controller;
use yii\console\Exception;

/**
 * Manage Extensions
 *
 * @author vistart <i@vistart.name>
 */
class ExtensionController extends Controller
{

    /**
     * List all registered extensions.
     * @return int
     */
    public function actionIndex()
    {
        $extensions = Extension::find()->all();
        if (empty($extensions)) {
            echo "<empty list>";
        }
        echo"|";
        echo sprintf("%28s", "Class Name");
        echo"|";
        echo sprintf("%4s", "Enb");
        echo"|";
        echo sprintf("%4s", "Mnp");
        echo"|";
        echo sprintf("%4s", "Dft");
        echo"|";
        echo sprintf("%20s", "Create Time");
        echo"|";
        echo sprintf("%20s", "Update Time");
        echo"|";
        echo "\r\n";
        foreach ($extensions as $extension) {
            echo"|";
            echo sprintf("%28s", $extension->classname);
            echo"|";
            echo sprintf("%4d", $extension->isEnabled);
            echo"|";
            echo sprintf("%4d", $extension->monopolized);
            echo"|";
            echo sprintf("%4d", $extension->default);
            echo"|";
            echo sprintf("%20s", $extension->createdAt);
            echo"|";
            echo sprintf("%20s", $extension->updatedAt);
            echo"|";
            echo "\r\n";
        }
        return 0;
    }

    /**
     * Register an extension.
     * @param string $class Full-qualified name of a extension.
     * @param boolean $enable Whether enable the module after adding it.
     * @return int
     */
    public function actionRegister($class, $enable = false)
    {
        try {
            $result = Yii::$app->rhoone->ext->register($class, $enable);
        } catch (\Exception $ex) {
            if (YII_ENV != YII_ENV_PROD) {
                throw $ex;
            }
            throw new Exception($ex->getMessage());
        }
        echo "The extension `" . $class . "` is added.\n";
        return 0;
    }

    /**
     * Enable an extension.
     * @param string $class
     * @return int
     */
    public function actionEnable($class)
    {
        try {
            if (Yii::$app->rhoone->ext->enable($class)) {
                echo "Enabled.";
            } else {
                echo "Failed to enable.";
            }
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        return 0;
    }

    /**
     * Disable an extension.
     * @param string $class
     * @return int
     */
    public function actionDisable($class)
    {
        try {
            if (Yii::$app->rhoone->ext->disable($class)) {
                echo "Disabled.";
            } else {
                echo "Failed to disable.";
            }
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        return 0;
    }

    /**
     * Validate extension.
     * @param string $class
     * @return int
     * @throws Exception
     */
    public function actionValidate($class)
    {
        try {
            Yii::$app->rhoone->ext->validate($class);
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        echo "No errors occured.";
        return 0;
    }

    /**
     * Remove an extension
     * @param string $class
     * @param boolean $force
     * @return int
     * @throws Exception
     */
    public function actionRemove($class, $force = false)
    {
        try {
            Yii::$app->rhoone->ext->deregister($class, $force);
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        echo "The extension `" . $class . "` is removed.\n";
        return 0;
    }
}

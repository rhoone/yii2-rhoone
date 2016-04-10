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

use rhoone\helpers\ExtensionHelper;
use yii\console\Controller;
use yii\console\Exception;

/**
 * Manage Extensions
 *
 * @author vistart <i@vistart.name>
 */
class ExtensionManagerController extends Controller
{

    /**
     * List all extension.
     * @return int
     */
    public function actionIndex()
    {
        $extensions = ExtensionHelper::all();
        if (empty($extensions)) {
            echo "<empty list>";
        }
        return 0;
    }

    /**
     * Add a extension.
     * @param string $class Full-qualified name of a extension.
     * @param boolean $enable Whether enable the module after adding it.
     */
    public function actionAdd($class, $enable = false)
    {
        try {
            $result = ExtensionHelper::add($class, $enable);
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        echo "The extension `" . $class . "` is added.\n";
        return 0;
    }

    /**
     * Remove a extension
     * @param string $class
     * @param boolean $force
     * @return int
     * @throws Exception
     */
    public function actionRemove($class, $force = false)
    {
        try {
            $result = ExtensionHelper::remove($class, $force);
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        echo "The extension `" . $class . "` is removed.\n";
        return 0;
    }
}

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

use rhoone\models\Extension as ExtModel;
use yii\di\ServiceLocator;

/**
 * Description of ExtensionManager
 *
 * @author vistart
 */
class ExtensionManager extends ServiceLocator
{

    public function init()
    {
        parent::init();
    }
    
    public static function all()
    {
        return ExtModel::find()->all();
    }

    protected function loadRegistered()
    {
        
    }

    /**
     * Returns the list of the extension definitions or the loaded extension instances.
     * @param boolean $returnDefinitions whether to return extension definitions instead of the loaded extension instances.
     * @return array the list of the extension definitions or the loaded extension instances (ID => definition or instance).
     */
    public function getExtensions($returnDefinitions = true)
    {
        return $this->getComponents($returnDefinitions);
    }
}

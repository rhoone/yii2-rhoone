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
use vistart\helpers\Number;
use Yii;
use yii\di\ServiceLocator;

/**
 * Description of ExtensionManager
 *
 * @property-read ExtModel[] $extensions
 * @author vistart <i@vistart.name>
 */
class ExtensionManager extends ServiceLocator
{

    public function init()
    {
        parent::init();
        $count = $this->loadEnabled();
        Yii::info("$count extension(s) loaded.");
    }

    /**
     * 
     * @param string $ext
     */
    protected function loadEnabled($ext = null)
    {
        if ($ext !== null && empty($ext)) {
            return 0;
        }
        if ($ext instanceof ExtModel) {
            $id = $ext->id;
            $classname = $ext->classname;
            $config = $ext->config;
            try {
                $this->set($id, new $classname($config));
            } catch (\Exception $ex) {
                Yii::error($ex->getMessage(), __METHOD__);
                return 0;
            }
            return 1;
        }
        if (is_string($ext) && preg_match(Number::GUID_REGEX, $ext)) {
            $ext = ExtModel::findOne($ext);
            if (!$ext) {
                Yii::error("`$ext` does not exist.", __METHOD__);
                return 0;
            }
            return $this->loadEnabled($ext);
        }
        if ($ext === null) {
            $count = 0;
            $exts = ExtModel::findAllEnabled();
            if (empty($exts)) {
                return 0;
            }
            foreach ($exts as $ext) {
                $count += $this->loadEnabled($ext);
            }
            return $count;
        }
        return 0;
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

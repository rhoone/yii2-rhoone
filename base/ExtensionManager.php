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
    use ExtensionHelperTrait;

    public function init()
    {
        parent::init();
        $count = $this->load();
        Yii::info("$count rhoone extension(s) loaded.", __METHOD__);
    }

    /**
     * Load enabled extension(s).
     * @param ExtModel|string|null $ext
     * `null` when you want to load all enabled extension(s).
     * `string` or `ExtModel` when you want to load specified extension.
     * @return int Sum of loaded extension(s).
     */
    public function load($ext = null)
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
            return $this->load($ext);
        }
        if ($ext === null) {
            $count = 0;
            $exts = ExtModel::find()->enabled()->all();
            if (empty($exts)) {
                return 0;
            }
            foreach ($exts as $ext) {
                $count += $this->load($ext);
            }
            return $count;
        }
        return 0;
    }
}

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

namespace rhoone;

use rhoone\helpers\ExtensionHelper;
use Yii;

/**
 * Description of Module
 *
 * @author vistart <i@vistart.name>
 */
class Module extends \yii\base\Module implements \yii\base\BootstrapInterface
{

    public $controllerNamespace = 'rhoone\controllers';

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $rules = [
                'search' => $this->id . '/search/index',
                'search/<keywords:\w+>' => $this->id . '/search/index'
            ];
            $app->getUrlManager()->addRules($rules);
        }
        $extensions = $this->getEnabledExtensions();
        foreach ($extensions as $ext) {
            $moduleConfig = $ext->getModule();
            $app->setModule($moduleConfig['id'], $moduleConfig);
            $module = $app->getModule($moduleConfig['id']);
            if ($module instanceof \yii\base\BootstrapInterface) {
                $app->bootstrap[] = $module->id;
                $module->bootstrap($app);
            }
        }
    }

    protected function getEnabledExtensions()
    {
        return ExtensionHelper::allEnabled();
    }
}

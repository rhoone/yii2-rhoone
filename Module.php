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
use yii\base\BootstrapInterface;
use Yii;

/**
 * Description of Module
 *
 * @author vistart <i@vistart.name>
 */
class Module extends \yii\base\Module implements BootstrapInterface
{

    public $controllerNamespace = 'rhoone\controllers';

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            Yii::trace('Adding URL Rules.', __METHOD__);
            $rules = [
                's/<keywords:.*>' => $this->id . '/search/index',
                'search' => $this->id . '/search/index',
                'subordinate/register' => $this->id . '/subordinate/register',
                'register-subordinate' => $this->id . '/subordinate/register-subordinate',
                'subordinate/deregister' => $this->id . '/subordinate/deregister',
                'deregister-subordinate' => $this->id . '/subordinate/deregister-subordinate',
            ];
            $app->getUrlManager()->addRules($rules);
        }
        $count = $this->bootstrapExtensions($app);
    }

    /**
     * Bootstrap with Extensions.
     * @param \yii\base\Application $app
     * @return int
     */
    protected function bootstrapExtensions($app)
    {
        $extensions = $this->getEnabledExtensions();
        if (empty($extensions)) {
            Yii::info('No extensions enabled.', __METHOD__);
        } else {
            Yii::info(count($extensions) . ' extensions enabled.', __METHOD__);
        }
        foreach ($extensions as $ext) {
            $moduleConfig = $ext->getModule();
            Yii::info($moduleConfig['id'] . ' enabled.', __METHOD__);
            $app->setModule($moduleConfig['id'], $moduleConfig);
            $module = $app->getModule($moduleConfig['id']);
            if ($module instanceof BootstrapInterface) {
                $app->bootstrap[] = $module->id;
                Yii::trace('Bootstrap with ' . $module->className() . '::' . 'bootstrap()', __METHOD__);
                $module->bootstrap($app);
            }
        }
        return count($extensions);
    }

    protected function getEnabledExtensions()
    {
        return ExtensionHelper::allEnabled();
    }
}

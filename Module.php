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
use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * Description of Module
 *
 * @author vistart <i@vistart.name>
 */
class Module extends \yii\base\Module implements BootstrapInterface
{

    public $controllerNamespace = 'rhoone\controllers';

    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['rhoone*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@rhoone/messages',
        ];
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $this->addRules($app);
        }
        $count = $this->registerComponents($app);
        Yii::info("$count component(s) registered.", __METHOD__);
        $count = $this->bootstrapExtensions($app);
        Yii::info("$count extension(s) bootstrapped.", __METHOD__);
        $extMgr = Yii::$app->rhoone->extensionManager;
        /* @var $extMgr \rhoone\base\ExtensionManager */
    }

    /**
     * 
     * @param Application $app
     */
    public function registerComponents($app)
    {
        $count = 0;
        foreach ($this->coreComponents() as $id => $component) {
            try {
                $app->set($id, $component);
            } catch (\Exception $ex) {
                Yii::error("`$id` failed to register: " . $ex->getMessage(), __METHOD__);
                continue;
            }
            Yii::info("`$id` registered.", __METHOD__);
            $count++;
        }
        return $count;
    }

    public function coreComponents()
    {
        return [
            'rhoone' => ['class' => 'rhoone\base\Rhoone'], // Required.
        ];
    }

    public function addRules($app)
    {
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
            return 0;
        }
        $extMgr = Yii::$app->rhoone->extensionManager;
        /* @var $extMgr \rhoone\base\ExtensionManager */
        foreach ($extMgr->getExtensions() as $id => $extension) {
            if ($extMgr->$id instanceof BootstrapInterface) {
                try {
                    $component->bootstrap($app);
                } catch (\Exception $ex) {
                    Yii::error($ex->getMessage(), __METHOD__);
                    continue;
                }
            }
        }
        Yii::info(count($extensions) . ' extensions enabled.', __METHOD__);

        $count = 0;
        foreach ($extensions as $ext) {
            $moduleConfig = $ext->getModule();
            if (empty($moduleConfig)) {
                continue;
            }
            Yii::info("`" . $moduleConfig['id'] . '` enabled.', __METHOD__);
            $app->setModule($moduleConfig['id'], $moduleConfig);
            $module = $app->getModule($moduleConfig['id']);
            if ($module instanceof BootstrapInterface) {
                $app->bootstrap[] = $module->id;
                Yii::trace('Bootstrap with ' . $module->className() . '::' . 'bootstrap()', __METHOD__);
                $module->bootstrap($app);
                $count++;
            }
        }
        return $count;
    }

    protected function getEnabledExtensions()
    {
        return ExtensionHelper::allEnabled();
    }
}

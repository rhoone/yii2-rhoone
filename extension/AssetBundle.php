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

namespace rhoone\extension;

/**
 * Description of AssetBundle
 *
 * @author vistart <i@vistart.name>
 */
class AssetBundle extends \yii\web\AssetBundle
{

    public $preloadAssets = [
        'rhoone\widgets\search\assets\SearchAsset',
        'rhoone\assets\RhooneAsset',
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'rhoone\assets\NprogressAsset',
        'yii\widgets\PjaxAsset'
    ];

    public function init()
    {
        $this->depends = $this->removePreloadAssets();
        parent::init();
    }

    protected function removePreloadAssets()
    {
        return array_diff($this->depends, $this->preloadAssets);
    }
}

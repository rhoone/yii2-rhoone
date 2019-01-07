<?php

/**
 *  _   __ __ _____ _____ ___  ____  _____
 * | | / // // ___//_  _//   ||  __||_   _|
 * | |/ // /(__  )  / / / /| || |     | |
 * |___//_//____/  /_/ /_/ |_||_|     |_|
 * @link https://vistart.me/
 * @copyright Copyright (c) 2016 - 2019 vistart
 * @license https://vistart.me/license/
 */

namespace rhoone\assets;

use yii\web\AssetBundle;

/**
 * NprogressAsset is primarily used to describe the essential assets of NProgress.
 *
 * @author vistart <i@vistart.me>
 */
class NprogressAsset extends AssetBundle
{

    public $sourcePath = "@bower/nprogress";
    public $js = [
        'nprogress' => 'nprogress.js',
    ];
    public $css = [
        'nprogress' => 'nprogress.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}

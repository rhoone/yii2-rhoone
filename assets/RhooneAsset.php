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
 * RhooneAsset is primarily used to describe the essential assets of Rhoone.
 *
 * @author vistart <i@vistart.me>
 */
class RhooneAsset extends AssetBundle
{

    public $sourcePath = "@rhoone/assets/rhoone";
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'rhoone' => 'js/rhoone.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}

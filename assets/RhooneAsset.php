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

namespace rhoone\assets;

use yii\web\AssetBundle;

/**
 * Description of RhooneAsset
 *
 * @author vistart <i@vistart.name>
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

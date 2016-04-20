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

namespace rhoone\widgets\search\assets;

use yii\web\AssetBundle;

/**
 * Description of SearchAsset
 *
 * @author vistart <i@vistart.name>
 */
class SearchAsset extends AssetBundle
{

    public $sourcePath = "@rhoone/widgets/search/assets";
    public $baseUrl = '@web';
    public $js = [
        'search' => 'js/rhoone.search.js',
    ];
    public $depends = [
        'rhoone\assets\RhooneAsset',
    ];

}

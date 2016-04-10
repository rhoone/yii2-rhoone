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

namespace rhoone\controllers;

use yii\web\Controller;

/**
 * Description of SearchController
 *
 * @author vistart <i@vistart.name>
 */
class SearchController extends Controller
{

    /**
     * 
     * @param string $keywords
     * @todo Extract keywords from $keywords
     * @todo Retrieve synonyms and headwords.
     * @todo Retrieve search results cache.
     * @todo Return result.
     */
    public function actionIndex($keywords = null)
    {
        return $keywords;
    }
}

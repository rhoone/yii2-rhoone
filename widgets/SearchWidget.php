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

namespace rhoone\widgets;

/**
 * Description of SearchWidget
 *
 * @author vistart <i@vistart.name>
 */
class SearchWidget extends \yii\base\Widget
{

    public $keywords;
    public $results;

    public function run()
    {
        return $this->render('search', ['keywords' => $this->keywords, 'results' => $this->results]);
    }
}

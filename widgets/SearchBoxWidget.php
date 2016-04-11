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
 * Description of SearchBoxWidget
 *
 * @author vistart <i@vistart.name>
 */
class SearchBoxWidget extends \yii\base\Widget
{

    public $keywords;

    public function run()
    {
        return $this->render('search-box', ['keywords' => $this->keywords]);
    }
}

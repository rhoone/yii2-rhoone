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
 * Description of SearchResultWidget
 *
 * @author vistart <i@vistart.name>
 */
class SearchResultWidget extends \yii\base\Widget
{

    public $results;
    public $search_result_id = "search-result-container";

    public function run()
    {
        return $this->render('search-result', ['results' => $this->results, 'search_result_id' => $this->search_result_id]);
    }
}

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

use rhoone\models\SearchForm;

/**
 * Description of SearchFormWidget
 *
 * @author vistart <i@vistart.name>
 */
class SearchFormWidget extends \yii\base\Widget
{

    public $keywords;
    public $searchForm;
    public $search_form_id = "search-form";
    public $search_input_id = "search-input-field";
    public $search_result_id = "search-result-container";
    public $search_submit_id = "search-submit";

    public function init()
    {
        if (empty($this->searchForm)) {
            $this->searchForm = new SearchForm(['keywords' => $this->keywords]);
        }
    }

    public function run()
    {
        return $this->render('search-form', [
                'model' => $this->searchForm,
                'search_form_id' => $this->search_form_id,
                'search_input_id' => $this->search_input_id,
                'search_result_id' => $this->search_result_id,
                'search_submit_id' => $this->search_submit_id,
        ]);
    }
}

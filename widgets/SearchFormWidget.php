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

    public $searchForm;

    public function init()
    {
        if (empty($this->searchForm)) {
            $this->searchForm = new SearchForm(['keywords' => '']);
        }
    }

    public function run()
    {
        return $this->render('search-form', ['model' => $this->searchForm]);
    }
}

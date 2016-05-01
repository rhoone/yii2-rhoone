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
use rhoone\widgets\search\PanelWidget;
use rhoone\widgets\search\ResultWidget;

/**
 * Search Widget。
 * This widget consists of two sub widgets: `PanelWidget` and `SearchWidget`.
 * @see PanelWidget
 * @see ResultWidget
 * 
 * We do not recommend using them seperately.
 *
 * @author vistart <i@vistart.name>
 */
class SearchWidget extends \yii\base\Widget
{

    /**
     * @var SearchForm The model used for search form. This model must contain `keywords` field.
     * If this parameter is not null, it will override `panelConfig['formConfig']['model']`
     * and `resultConfig['formConfig']['model']`.
     */
    public $model;

    /**
     * @var array Panel widget config.
     * @see PanelWidget
     */
    public $panelConfig;

    /**
     * @var array Result widget config.
     * @see ResultConfig
     */
    public $resultConfig;

    public function init()
    {
        if (!is_array($this->panelConfig)) {
            $this->panelConfig = [];
        }
        if (empty($this->panelConfig)) {
            $this->panelConfig['formConfig'] = null;
        }
        if ($this->model !== null) {
            $this->panelConfig['formConfig']['model'] = $this->model;
        }
        if (!is_array($this->resultConfig)) {
            $this->resultConfig = [];
        }
        if ($this->model !== null) {
            $this->resultConfig['formConfig']['model'] = $this->model;
        }
    }

    public function run()
    {
        return $this->render('search', [
                'panelConfig' => $this->panelConfig,
                'resultConfig' => $this->resultConfig,
        ]);
    }
}

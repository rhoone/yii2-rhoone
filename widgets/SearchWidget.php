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

    public $model;
    public $panelConfig;
    public $resultConfig;

    public function init()
    {
        if (!is_array($this->panelConfig)) {
            $this->panelConfig = [];
        }
        if (empty($this->panelConfig)) {
            $this->panelConfig['formConfig'] = null;
        }
        $this->panelConfig['formConfig']['model'] = $this->model;
        if (!is_array($this->resultConfig)) {
            $this->resultConfig = [];
        }
        $this->resultConfig['formConfig']['model'] = $this->model;
    }

    public function run()
    {
        return $this->render('search', [
                'panelConfig' => $this->panelConfig,
                'resultConfig' => $this->resultConfig,
        ]);
    }
}

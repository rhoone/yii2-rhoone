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

    public $panelConfig;
    public $resultConfig;

    public function init()
    {
        if (empty($this->panelConfig)) {
            $this->panelConfig['formConfig'] = null;
        }
        if (empty($this->resultConfig)) {
            $this->resultConfig['pjaxConfig'] = null;
            $this->resultConfig['containerConfig'] = null;
            $this->resultConfig['formConfig'] = null;
        }
    }

    public function run()
    {
        return $this->render('search', ['panelConfig' => $this->panelConfig, 'resultConfig' => $this->resultConfig,]);
    }
}

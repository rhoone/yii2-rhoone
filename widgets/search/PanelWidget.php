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

namespace rhoone\widgets\search;

use rhoone\widgets\search\panel\FormWidget;
use yii\base\Widget;

/**
 * Panel Widget
 *
 * @author vistart <i@vistart.name>
 */
class PanelWidget extends Widget
{

    /**
     * @var array From widget config.
     * This config array contains four elements:
     * `model`
     * `formConfig`
     * `inputConfig`
     * `submitConfig`
     * @see FormWidget
     */
    public $formConfig;

    public function init()
    {
        if (!is_array($this->formConfig)) {
            $this->formConfig = [];
        }
    }

    public function run()
    {
        return $this->render('panel', ['formConfig' => $this->formConfig]);
    }
}

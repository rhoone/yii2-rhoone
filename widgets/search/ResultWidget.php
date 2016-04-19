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

use rhoone\widgets\search\result\FormWidget;
use rhoone\widgets\search\result\ContainerWidget;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * Description of ResultWidget
 *
 * @author vistart <i@vistart.name>
 */
class ResultWidget extends Widget
{

    /**
     * @var array 
     */
    public $pjaxConfig;

    /**
     * @var array 
     * @see ContainerWidget
     */
    public $containerConfig;

    /**
     * @var array The configuration array of form.
     * You must set the ID attribute.
     * @see FormWidget
     * @see ActiveForm
     */
    public $formConfig;

    const INIT_PJAX_ID = "pjax-search-result";
    const INIT_PJAX_TIMEOUT = 5000;

    public function init()
    {
        if (!is_array($this->containerConfig)) {
            $this->containerConfig = [
                'id' => ContainerWidget::INIT_CONTAINER_ID,
            ];
        }
        if (!is_array($this->formConfig)) {
            $this->formConfig = [
                'id' => FormWidget::INIT_FORM_ID,
                'action' => Url::current(),
                'enableClientScript' => false,
                'enableClientValidation' => false,
            ];
        }
        if (!is_array($this->pjaxConfig)) {
            $this->pjaxConfig = [
                'id' => self::INIT_PJAX_ID,
                'linkSelector' => false,
                'formSelector' => "#" . $this->formConfig['id'],
                'timeout' => self::INIT_PJAX_TIMEOUT,
            ];
        }
    }

    public function run()
    {
        return $this->render('result', ['pjaxConfig' => $this->pjaxConfig, 'containerConfig' => $this->containerConfig, 'formConfig' => $this->formConfig]);
    }
}

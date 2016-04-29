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
use yii\helpers\ArrayHelper;
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

    /**
     * @var array The configuration array of keywords field.
     * @see FormWidget
     */
    public $keywordsFieldConfig;
    public $searchUrlPattern;
    public $results;

    const INIT_PJAX_ID = "pjax-search-result";
    const INIT_PJAX_TIMEOUT = 5000;

    public function init()
    {
        if (!is_array($this->pjaxConfig)) {
            $this->pjaxConfig = [];
        }
        if (is_array($this->pjaxConfig)) {
            $this->pjaxConfig = ArrayHelper::merge(static::getPjaxConfig(), $this->pjaxConfig);
        }
        if (!is_array($this->formConfig)) {
            $this->formConfig = [];
        }
        if (!isset($this->formConfig['formConfig']) || !is_array($this->formConfig['formConfig'])) {
            $this->formConfig['formConfig'] = [];
        }
        if (is_array($this->formConfig['formConfig'])) {
            $this->formConfig['formConfig'] = ArrayHelper::merge(FormWidget::getFormConfig(), $this->formConfig['formConfig']);
        }
        if (!isset($this->formConfig['keywordsFieldConfig']) || !is_array($this->formConfig['keywordsFieldConfig'])) {
            $this->formConfig['keywordsFieldConfig'] = [];
        }
        if (is_array($this->formConfig['keywordsFieldConfig'])) {
            $this->formConfig['keywordsFieldConfig'] = ArrayHelper::merge(FormWidget::getKeywordsFieldConfig(), $this->formConfig['keywordsFieldConfig']);
        }
        if (!isset($this->pjaxConfig['formSelector'])) {
            $this->pjaxConfig['formSelector'] = "#" . $this->formConfig['formConfig']['id'];
        }
        if (empty($this->searchUrlPattern) || !is_string($this->searchUrlPattern)) {
            $this->searchUrlPattern = Url::home() . "s?q={{%keywords}}";
        }
    }

    public static function getPjaxConfig()
    {
        return [
            'id' => self::INIT_PJAX_ID,
            'linkSelector' => false,
            'timeout' => self::INIT_PJAX_TIMEOUT,
        ];
    }

    public function run()
    {
        return $this->render('result', [
                'pjaxConfig' => $this->pjaxConfig,
                'containerConfig' => $this->containerConfig,
                'formConfig' => $this->formConfig,
                'keywordsFieldConfig' => $this->keywordsFieldConfig,
                'searchUrlPattern' => $this->searchUrlPattern,
        ]);
    }
}

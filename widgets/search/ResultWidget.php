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
use yii\widgets\Pjax;
use yii\helpers\Url;

/**
 * Description of ResultWidget
 *
 * @author vistart <i@vistart.name>
 */
class ResultWidget extends Widget
{

    /**
     * @var array The config array used for pjax widget.
     * @see Pjax
     */
    public $pjaxConfig;

    /**
     * @var array The config array used for container widget.
     * @see ContainerWidget
     */
    public $containerConfig;

    /**
     * @var array The config array used for search form.
     * This form is actually used for keywords submission.
     * You must set the ID attribute and ensure it unique overall the whole page.
     * @see FormWidget
     * @see ActiveForm
     */
    public $formConfig;

    /**
     * @var array The configuration array of keywords field.
     * @see FormWidget
     */
    public $keywordsFieldConfig;

    /**
     * @var string Search URL Pattern. This pattern should contain `{{%keywords}}`
     * anchor, or specified by {{$this->searchUrlPatternAnchor}},
     * which will be replaced with actual keywords. For example:
     * ```
     * $this->searchUrlPattern = 's?q={{%keywords}}';
     * ```
     * It is not necessary to add the leading slash to the pattern string.
     * 
     * If your search URL pattern does not contain the anchor, it will be attached to the end automatically.
     */
    public $searchUrlPattern = 's?q={{%keywords}}';

    /**
     * @var string Search URL Pattern Anchor. 
     */
    public $searchUrlPatternAnchor = '{{%keywords}}';

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
        if (empty($this->searchUrlPatternAnchor) || !is_string($this->searchUrlPatternAnchor)) {
            $this->searchUrlPatternAnchor = '{{%keywords}}';
        }
        if (empty($this->searchUrlPattern) || !is_string($this->searchUrlPattern)) {
            $this->searchUrlPattern = Url::home() . "s";
        }
        if (strpos($this->searchUrlPattern, $this->searchUrlPatternAnchor) === false) {
            $this->searchUrlPattern .= "?q=" . $this->searchUrlPatternAnchor;
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

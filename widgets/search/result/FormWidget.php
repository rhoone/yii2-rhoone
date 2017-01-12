<?php

/**
 *  _   __ __ _____ _____ ___  ____  _____
 * | | / // // ___//_  _//   ||  __||_   _|
 * | |/ // /(__  )  / / / /| || |     | |
 * |___//_//____/  /_/ /_/ |_||_|     |_|
 * @link https://vistart.me/
 * @copyright Copyright (c) 2016 - 2017 vistart
 * @license https://vistart.me/license/
 */

namespace rhoone\widgets\search\result;

use rhoone\models\SearchForm;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * This form widget is used for submitting the search keywords.
 * This form only contains a hidden field for storing the search keywords.
 * 
 * @author vistart <i@vistart.me>
 */
class FormWidget extends Widget
{

    /**
     * @var array The config array used for form.
     * You must set the ID attribute.
     * @see ActiveForm
     */
    public $formConfig;

    /**
     * @var array The config array used for keywords field.
     */
    public $keywordsFieldConfig;

    /**
     * @var SearchForm The model used for search form. This model must contain `keywords` field.
     */
    public $model;

    const INIT_FORM_ID = "search-result-form";
    const INIT_FORM_KEYWORDS_ID = "search-result-form-keywords";

    public function init()
    {
        if (!is_array($this->formConfig)) {
            $this->formConfig = [];
        }
        if (is_array($this->formConfig)) {
            $this->formConfig = ArrayHelper::merge(static::getFormConfig(), $this->formConfig);
        }
        if (!isset($this->formConfig['id'])) {
            throw new InvalidConfigException('The ID of form should be set.');
        }
        if (!is_array($this->keywordsFieldConfig)) {
            $this->keywordsFieldConfig = [];
        }
        if (is_array($this->keywordsFieldConfig)) {
            $this->keywordsFieldConfig = ArrayHelper::merge(static::getKeywordsFieldConfig(), $this->keywordsFieldConfig);
        }
        if (!isset($this->keywordsFieldConfig['id'])) {
            throw new InvalidConfigException('The ID of keywords field should be set.');
        }
        if (empty($this->model) && class_exists('\rhoone\models\SearchForm')) {
            $this->model = new \rhoone\models\SearchForm();
        }
    }

    /**
     * ID must be set.
     * @return array from config
     */
    public static function getFormConfig()
    {
        return [
            'id' => self::INIT_FORM_ID,
            'action' => Url::current(),
            'enableClientScript' => false,
            'enableClientValidation' => false,
        ];
    }

    /**
     * ID must be set.
     * @return array keywords field config
     */
    public static function getKeywordsFieldConfig()
    {
        return [
            'id' => self::INIT_FORM_KEYWORDS_ID,
        ];
    }

    public function run()
    {
        return $this->render('form', [
                'formConfig' => $this->formConfig,
                'keywordsFieldConfig' => $this->keywordsFieldConfig,
                'model' => $this->model
        ]);
    }
}

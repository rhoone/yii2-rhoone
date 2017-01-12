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

namespace rhoone\widgets\search\panel;

use rhoone\models\SearchForm;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * Form widget used for panel widget.
 * This form is only used for receiving the keywords, not submitting them.
 *
 * @author vistart <i@vistart.me>
 */
class FormWidget extends Widget
{

    /**
     * @var SearchFrom The model used for search form. This model must contain `keywords` field.
     */
    public $model;
    public $formConfig;
    public $inputConfig;
    public $submitConfig;

    public function init()
    {
        if (!is_array($this->formConfig)) {
            $this->formConfig = [];
        }
        if (is_array($this->formConfig)) {
            $this->formConfig = ArrayHelper::merge(static::getFormConfig(), $this->formConfig);
        }
        if (!is_array($this->inputConfig)) {
            $this->inputConfig = [];
        }
        if (is_array($this->inputConfig)) {
            $this->inputConfig = ArrayHelper::merge(static::getInputConfig(), $this->inputConfig);
        }
        if (!is_array($this->submitConfig)) {
            $this->submitConfig = [];
        }
        if (is_array($this->submitConfig)) {
            $this->submitConfig = ArrayHelper::merge(static::getSubmitConfig(), $this->submitConfig);
        }
        if (empty($this->model)) {
            $this->model = new SearchForm();
        }
        $this->registerTranslations();
    }

    /**
     * ID must be set.
     * @return array input field config
     */
    public static function getInputConfig()
    {
        return [
            'class' => 'form-control form-search',
            'id' => 'search-input-field',
            'placeholder' => 'Search for everything we know.'
        ];
    }

    /**
     * ID must be set.
     * We do not recommend that enabling the client script and validation.
     * @return array form config
     */
    public static function getFormConfig()
    {
        return [
            'id' => 'search-form',
            'enableClientScript' => false,
            'enableClientValidation' => false,
        ];
    }

    /**
     * ID must be set.
     * @return array submit button config
     */
    public static function getSubmitConfig()
    {
        return [
            'id' => "search-submit",
            'class' => 'btn btn-default btn-sm form-button-search',
        ];
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['rhoone.widgets.search.panel.form'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@rhoone/widgets/search/panel/messages',
        ];
    }

    public static function t($message, $params = [], $language = null)
    {
        return Yii::t('rhoone.widgets.search.panel.form', $message, $params, $language);
    }

    public function run()
    {
        return $this->render('form', [
                'model' => $this->model,
                'formConfig' => $this->formConfig,
                'inputConfig' => $this->inputConfig,
                'submitConfig' => $this->submitConfig
        ]);
    }
}

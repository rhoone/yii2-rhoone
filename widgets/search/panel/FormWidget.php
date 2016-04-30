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

namespace rhoone\widgets\search\panel;

use rhoone\models\SearchForm;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * Form widget used for panel widget.
 * This form is only used for receiving the keywords, not submitting them.
 *
 * @author vistart <i@vistart.name>
 */
class FormWidget extends Widget
{

    /**
     * @var SearchFrom 
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
        if (empty($this->model) && class_exists('\rhoone\models\SearchForm')) {
            $this->model = new SearchForm();
        }
        $this->registerTranslations();
    }

    public static function getInputConfig()
    {
        return [
            'class' => 'form-control form-search',
            'id' => 'search-input-field',
            'placeholder' => 'Search for everything we know.'
        ];
    }

    public static function getFormConfig()
    {
        return [
            'id' => 'search-form',
            'enableClientScript' => false,
            'enableClientValidation' => false,
        ];
    }

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

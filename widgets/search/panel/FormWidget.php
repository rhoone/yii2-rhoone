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

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * Description of FormWidget
 *
 * @author vistart <i@vistart.name>
 */
class FormWidget extends Widget
{

    public $modelClass;
    public $formConfig;
    public $inputConfig;
    public $submitConfig;
    private $_model;

    public function init()
    {
        if (empty($this->modelClass) || !class_exists($this->modelClass)) {
            $this->modelClass = \rhoone\models\SearchForm::className();
        }
        $modelClass = $this->modelClass;
        $this->_model = new $modelClass();
        if (!is_array($this->formConfig)) {
            $this->formConfig = [
                'id' => 'search-form',
                'action' => Url::toRoute(['index', 'keywords' => $this->_model->keywords]),
                'enableClientScript' => false,
                'enableClientValidation' => false,
            ];
        }
        if (!is_array($this->inputConfig)) {
            $this->inputConfig = [
                'class' => 'form-control form-search',
                'id' => 'search-input-field',
                'placeholder' => 'Search for all.'
            ];
        }
        if (!is_array($this->submitConfig)) {
            $this->submitConfig = [
                'id' => "search-submit",
                'class' => 'btn btn-default btn-sm form-button-search',
                'data-pjax' => 1
            ];
        }
        $this->registerTranslations();
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
                'model' => $this->_model,
                'formConfig' => $this->formConfig,
                'inputConfig' => $this->inputConfig,
                'submitConfig' => $this->submitConfig
        ]);
    }
}

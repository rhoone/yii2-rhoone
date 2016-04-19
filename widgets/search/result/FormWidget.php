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

namespace rhoone\widgets\search\result;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * This form widget is used for submitting the search keywords.
 * This form only contains a hidden field for storing the search keywords.
 * 
 * @author vistart <i@vistart.name>
 */
class FormWidget extends Widget
{

    /**
     * @var array The configuration array of form.
     * You must set the ID attribute.
     * @see ActiveForm
     */
    public $formConfig;

    /**
     * @var array The configuration array of keywords field.
     */
    public $keywordsFieldConfig;

    /**
     * @var string 
     */
    public $modelClass;

    const INIT_FORM_ID = "search-result-form";
    const INIT_FORM_KEYWORDS_ID = "search-result-form-keywords";

    public function init()
    {
        if (!is_array($this->formConfig)) {
            $this->formConfig = [
                'id' => self::INIT_FORM_ID,
                'action' => Url::current(),
                'enableClientScript' => false,
                'enableClientValidation' => false,
            ];
        }
        if (!isset($this->formConfig['id'])) {
            throw new InvalidConfigException('The ID of form should be set.');
        }
        if (!is_array($this->keywordsFieldConfig)) {
            $this->keywordsFieldConfig = [
                'id' => self::INIT_FORM_KEYWORDS_ID,
            ];
        }
        if (empty($this->modelClass) || !class_exists($this->modelClass)) {
            $this->modelClass = \rhoone\models\SearchForm::className();
        }
    }

    public function run()
    {
        $modelClass = $this->modelClass;
        return $this->render('form', ['formConfig' => $this->formConfig, 'keywordsFieldConfig' => $this->keywordsFieldConfig, 'model' => new $modelClass()]);
    }
}

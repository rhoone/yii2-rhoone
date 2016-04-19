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
use yii\widgets\ActiveForm;

/* @var $formConfig array */
/* @var $keywordsFieldConfig array */
$form = ActiveForm::begin($formConfig);
/* @var $form ActiveForm */
echo $form->field($form, 'keywords')->hiddenInput($keywordsFieldConfig);
ActiveForm::end();

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
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $formConfig array */
/* @var $keywordsFieldConfig array */
/* @var $model mixed */
/* @var $this yii\web\View */

$form = ActiveForm::begin($formConfig);
/* @var $form ActiveForm */
echo $form->field($model, 'keywords', ['template' => '{input}'])->hiddenInput($keywordsFieldConfig);
echo Html::submitButton('', ['class' => 'hidden']);
ActiveForm::end();

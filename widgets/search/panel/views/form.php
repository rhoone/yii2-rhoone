<?php
/* *
 *  _   __ __ _____ _____ ___  ____  _____
 * | | / // // ___//_  _//   ||  __||_   _|
 * | |/ // /(__  )  / / / /| || |     | |
 * |___//_//____/  /_/ /_/ |_||_|     |_|
 * @link https://vistart.name/
 * @copyright Copyright (c) 2016 vistart
 * @license https://vistart.name/license/
 */

use rhoone\widgets\search\panel\FormWidget;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $formConfig array */
/* @var $inputConfig array */
/* @var $submitConfig array */
/* @var $this View */
$form = ActiveForm::begin($formConfig);
/* @var $form yii\widgets\ActiveForm */
$form_id = $form->id;
$input_id = $inputConfig['id'];
$submit_id = $submitConfig['id'];
/**
 * 
 */
$js = <<<EOT
    $("#$form_id").submit(function(){return false;});
    $("#$input_id").bind("input", function (e) {});
    $("#$input_id").bind("propertychanged", function (e) {});
EOT;
$this->registerJs($js);
?>
<div class="form-group form-group-search">
    <?= $form->field($model, 'keywords', ['template' => '{input}'])->textInput($inputConfig) ?>
    <?= Html::submitButton(FormWidget::t('Search'), $submitConfig); ?>
</div>
<?php
ActiveForm::end();

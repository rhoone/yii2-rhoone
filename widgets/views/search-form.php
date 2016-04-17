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
/* @var $model rhoone\models\SearchForm */
/* @var $this yii\web\View */
/* @var $search_form_id string */
/* @var $search_input_id string */
/* @var $search_result_id string */
/* @var $search_submit_id string */
use rhoone\assets\RhooneAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

RhooneAsset::register($this);
?>

<?php
$form = ActiveForm::begin([
        'id' => $search_form_id,
        'action' => Url::toRoute(['index', 'keywords' => $model->keywords]),
    ]);
/* @var $form yii\widgets\ActiveForm */
?>
<div class="form-group form-group-search">
    <?= $form->field($model, 'keywords', ['template' => '{input}'])->textInput(['class' => 'form-control form-search', 'id' => $search_input_id, 'placeholder' => 'Search for all.']) ?>
    <?= Html::submitButton('Search', ['id' => "$search_submit_id", 'class' => 'btn btn-default btn-sm form-button-search', 'data-pjax' => 1]); ?>
</div>
<?php
ActiveForm::end();
?>
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

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php
$form = ActiveForm::begin([
    'id' => 'search-form',
    'action' => Url::toRoute(['/search']),
]);
/* @var $form yii\widgets\ActiveForm */
?>
<div class="form-group form-group-search">
    <?= $form->field($model, 'keywords', ['template' => '{input}'])->textInput(['class' => 'form-control form-search', 'id' => 'search-input-field', 'placeholder' => 'Search for all.']) ?>
    <?= Html::submitButton('Search', ['id' => 'search-submit', 'class' => 'btn btn-default btn-sm form-button-search']); ?>
</div>
<?php
ActiveForm::end();
?>
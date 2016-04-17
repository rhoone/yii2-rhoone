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
/* @var $search_result_id string */
use rhoone\assets\RhooneAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

RhooneAsset::register($this);
$search_url = Url::toRoute('/search');
$search_button_id = "search-submit";
$js = <<<EOT
    rhoone.search_box_selector = "#$search_form_id";
    rhoone.search_result_selector = "#$search_result_id";
    rhoone.search_button_selector = "#$search_button_id";
    rhoone.search_url = "$search_url";
    rhoone.search_start_handler = function() {
        NProgress.start();
    };
    rhoone.search_done_handler = function() {
        NProgress.done();
    };
    rhoone.init();
EOT;
$this->registerJs($js);
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
    <?= Html::button('Search', ['id' => "$search_button_id", 'class' => 'btn btn-default btn-sm form-button-search']); ?>
</div>
<?php
ActiveForm::end();
?>
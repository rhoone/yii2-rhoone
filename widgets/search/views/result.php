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
use yii\widgets\Pjax;
use rhoone\widgets\search\assets\SearchAsset;
use rhoone\widgets\search\result\ContainerWidget;
use rhoone\widgets\search\result\FormWidget;
SearchAsset::register($this);
/* @var $pjaxConfig array */
/* @var $containerConfig array */
/* @var $formConfig array */
/* @var $searchUrlPattern string */
/* @var $this yii\web\View */
$formId = $formConfig['formConfig']['id'];
$keywordsInputId = $formConfig['keywordsFieldConfig']['id'];
$js = <<<EOT
    var pattern = "$searchUrlPattern";
    $(document).bind("pjax:complete", rhoone.search.end);
    $(document).bind("pjax:timeout", rhoone.search.cancel);
    $(document).bind("rhoone:search_start", {pattern: pattern}, function(e) {
        $("#$keywordsInputId").attr("value", rhoone.search.keywords);
        $("#$formId").attr("action", e.data.pattern.replace("{{%keywords}}",$("#$keywordsInputId").val()));
        $("#$formId").submit();
    });
EOT;
$this->registerJs($js);

/**
 * If current request is PJAX one, the above content wrapped in `Pjax` only will be returned, the other will be ignored.
 */
$pjax = Pjax::begin($pjaxConfig);
echo ContainerWidget::widget($containerConfig);
echo FormWidget::widget($formConfig);
Pjax::end();

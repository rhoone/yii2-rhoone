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
use yii\widgets\Pjax;
use rhoone\widgets\search\result\ContainerWidget;
use rhoone\widgets\search\result\FormWidget;

/* @var $pjaxConfig array */
/* @var $containerConfig array */
/* @var $formConfig array */
/* @var $this yii\web\View */
$formId = $formConfig['formConfig']['id'];
$keywordsInputId = $formConfig['keywordsFieldConfig']['id'];
$js = <<<EOT
    var pattern = "/s/{{%keywords}}";
    $(document).bind("pjax:complete", rhoone.search.end);
    $(document).bind("pjax:timeout", rhoone.search.cancel);
    $(document).bind("rhoone:search_start", {pattern: pattern}, function(e) {
        $("#$keywordsInputId").attr("value", rhoone.search.keywords);
        $("#$formId").attr("action", e.data.pattern.replace("{{%keywords}}",$("#$keywordsInputId").val()));
        $("#$formId").submit();
    });
EOT;
$this->registerJs($js);
$pjax = Pjax::begin($pjaxConfig);
echo ContainerWidget::widget($containerConfig);
echo FormWidget::widget($formConfig);
Pjax::end();

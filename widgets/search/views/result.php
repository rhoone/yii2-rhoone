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
if (isset(Yii::$app->params['cnzz']['ajaxTrackPageView']) && Yii::$app->params['cnzz']['ajaxTrackPageView'] == true)
{
    $jsCnzz = <<<EOT
        var _currentPage = $("#$formId").attr("action");
        if (typeof document.referrer == "undefined" || document.referrer == null || document.referrer == "") {
            _czc.push(﻿["_trackPageview", _currentPage]);
        } else {
            _czc.push(﻿["_trackPageview", _currentPage, document.referrer]);
        }
EOT;
}
$js = <<<EOT
    function replace_html_chars(subject) {
        return subject.replace(/%/g, "%25").replace(/[+]/g, "%2b").replace(/#/g, "%23").replace(/&/g, "%26");
    }
    var pattern = "$searchUrlPattern";
    $(document).bind("pjax:complete", rhoone.search.end);
    $(document).bind("pjax:timeout", rhoone.search.cancel);
    $(document).bind("rhoone:search_start", {pattern: pattern}, function(e) {
        $("#$keywordsInputId").attr("value", rhoone.search.keywords);
        $("#$formId").attr("action", replace_html_chars(e.data.pattern.replace("{{%keywords}}",$("#$keywordsInputId").val())));
        $("#$formId").submit();
        $jsCnzz
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

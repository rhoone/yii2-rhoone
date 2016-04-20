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

$form_id = $formConfig['id'];
$input_id = $inputConfig['id'];
$submit_id = $submitConfig['id'];
/**
 * 
 */
$js = <<<EOT
    function html_encode(str) {
        var s = "";
        if (str.length === 0)
            return "";
        s = str.replace(/&/g, "&gt;");
        s = s.replace(/</g, "&lt;");
        s = s.replace(/>/g, "&gt;");
        s = s.replace(/ /g, "&nbsp;");
        s = s.replace(/\'/g, "&#39;");
        s = s.replace(/\"/g, "&quot;");
        s = s.replace(/\\n/g, "<br>");
        return s;
    }
    function search_input_changed(e) {
        rhoone.search.keywords = $.trim($("#$input_id").val());
        rhoone.search.delay_start();
    }
    $("#$form_id").submit(function(){
        rhoone.search.start();
        return false;
    });
    $("#$input_id").bind("input", search_input_changed);
    $("#$input_id").bind("propertychanged", search_input_changed);
    rhoone.search.keywords = $.trim($("#$input_id").val());
    if (rhoone.search.keywords !== "") {
        $("title").html("Search: " + html_encode(rhoone.search.keywords));
    }
    $(document).bind("rhoone:search_start", function(e) {
        $("title").html("Search: " + html_encode(rhoone.search.keywords));
    });
    $("#$input_id").focus();
    
EOT;
$this->registerJs($js);

$form = ActiveForm::begin($formConfig);
/* @var $form yii\widgets\ActiveForm */
?>
<div class="form-group form-group-search">
    <?= $form->field($model, 'keywords', ['template' => '{input}'])->textInput($inputConfig) ?>
    <?= Html::submitButton(FormWidget::t('Search'), $submitConfig); ?>
</div>
<?php
ActiveForm::end();

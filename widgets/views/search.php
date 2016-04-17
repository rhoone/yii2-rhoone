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
/* @var $keywords string */
/* @var $results string[] */
/* @var $search_form_id string */
/* @var $search_input_id string */
/* @var $search_result_id string */
/* @var $search_submit_id string */
use rhoone\widgets\SearchBoxWidget;
use rhoone\widgets\SearchResultWidget;
use yii\helpers\Url;
use yii\widgets\Pjax;
?>
<?php

$current_url = Url::current();

$js = <<<EOT
    rhoone.search_form_selector = "#$search_form_id";
    rhoone.search_box_selector = "#$search_input_id";
    rhoone.search_result_selector = "#$search_result_id";
    rhoone.search_button_selector = "#$search_submit_id";
    rhoone.search_url = "$current_url";
    rhoone.search_url_pattern = '/s/{{%keywords}}';
    $('#pjax-$search_result_id').on('pjax:start', function() {
        NProgress.start();
    });
    $('#pjax-$search_result_id').on('pjax:complete', function() {
        NProgress.done();
    });
    rhoone.init();
EOT;
?>
<?php Pjax::begin(['id' => "pjax-$search_result_id", 'linkSelector' => false, 'formSelector' => "#$search_form_id", 'timeout' => 5000]) ?>

<?=

SearchBoxWidget::widget(
    [
        'keywords' => $keywords,
        'search_form_id' => $search_form_id,
        'search_input_id' => $search_input_id,
        'search_result_id' => $search_result_id,
        'search_submit_id' => $search_submit_id,
])
?>
<?=

SearchResultWidget::widget(
    [
        'results' => $results,
        'search_result_id' => $search_result_id
])
?>
<?php

if (Yii::$app->request->isAjax || Yii::$app->request->isPjax) {
    $this->registerJs($js, \yii\web\View::POS_BEGIN);
} else {
    $this->registerJs($js);
}
?>
<?php Pjax::end() ?>
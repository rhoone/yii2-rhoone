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
use rhoone\assets\NprogressAsset;
use rhoone\assets\RhooneAsset;

/* @var $keywords string */
/* @var $search_form_id string */
/* @var $search_result_id string */
NprogressAsset::register($this);
RhooneAsset::register($this);
?>
<div class="panel">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?= \rhoone\widgets\SearchFormWidget::widget(['keywords' => $keywords, 'search_form_id' => $search_form_id, 'search_result_id' => $search_result_id]) ?>
            </div>
            <div class="col-md-3">
            </div>
        </div>
        <?php if (false && YII_ENV == YII_ENV_DEV): ?>
            <p>
                <button class='button play' id='b-0'></button>
                <i>NProgress</i><b>.start()</b>
                &mdash;
                shows the progress bar
            </p>
            <p>
                <button class='button play' id='b-40'></button>
                <i>NProgress</i><b>.set(0.4)</b>
                &mdash;
                sets a percentage
            </p>
            <p>
                <button class='button play' id='b-inc'></button>
                <i>NProgress</i><b>.inc()</b>
                &mdash;
                increments by a little
            </p>
            <p>
                <button class='button play' id='b-100'></button>
                <i>NProgress</i><b>.done()</b>
                &mdash;
                completes the progress
            </p>
        <?php endif; ?>
    </div>
</div>
<?php
$dev = <<<EOT
    $("#b-0").click(function() { NProgress.start(); });
    $("#b-40").click(function() { NProgress.set(0.4); });
    $("#b-inc").click(function() { NProgress.inc(); });
    $("#b-100").click(function() { NProgress.done(); });
EOT;
$js = <<<EOT
    NProgress.configure({ showSpinner: false });
    NProgress.configure({ parent:'.panel-heading' });
    NProgress.start();
    setTimeout(function() { NProgress.done(); $('.fade').removeClass('out'); }, 1000);

EOT;
$this->registerJs($js, \yii\web\View::POS_READY);
if (YII_ENV == YII_ENV_DEV) {
    $this->registerJs($dev, \yii\web\View::POS_READY);
}
?>
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
use rhoone\assets\NprogressAsset;
use rhoone\widgets\search\assets\SearchAsset;
use rhoone\widgets\search\panel\FormWidget;
SearchAsset::register($this);
NprogressAsset::register($this);
$js = <<<EOT
    NProgress.configure({ showSpinner: false , parent:'.panel-heading'});
    NProgress.start();
    setTimeout(function(){NProgress.done();}, 1000);
    $(document).bind("rhoone:search_start", NProgress.start);
    $(document).bind("rhoone:search_cancel", NProgress.done);
    $(document).bind("rhoone:search_end", NProgress.done);
EOT;
$this->registerJs($js);
/* @var $formConfig array */
?>
<div class="panel">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?= FormWidget::widget($formConfig) ?>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>

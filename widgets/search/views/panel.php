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
use rhoone\widgets\search\panel\FormWidget;

NprogressAsset::register($this);
$js = <<<EOT
    NProgress.configure({ showSpinner: false , parent:'.panel-heading'});
    NProgress.start();
    setTimeout(function(){NProgress.done();}, 1000);
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
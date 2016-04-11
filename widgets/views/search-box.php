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
?>
<div class="panel">
    <div class="panel-heading"><strong>Search</strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?= \rhoone\widgets\SearchFormWidget::widget(['keywords' => $keywords]) ?>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</div>
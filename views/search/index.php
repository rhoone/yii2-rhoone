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
/* @var $keywords string */
/* @var $results string[] */
use rhoone\widgets\SearchWidget;

$this->title = 'Search';
?>

<div class="row">
    <div class="col-md-12">
        <?= SearchWidget::widget(['model' => $model, 'resultConfig' => ['containerConfig' => ['results' => $results]]]) ?>
    </div>
</div>
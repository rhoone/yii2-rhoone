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
$this->title = 'Search';
?>

<div class="row">
    <div class="col-md-12">
        <?= \rhoone\widgets\SearchWidget::widget(['keywords' => $keywords, 'results' => $results]) ?>
    </div>
</div>
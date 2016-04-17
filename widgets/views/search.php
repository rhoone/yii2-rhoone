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
/* @var $search_result_id string */
use rhoone\widgets\SearchBoxWidget;
use rhoone\widgets\SearchResultWidget;

?>
<?= SearchBoxWidget::widget(['keywords' => $keywords, 'search_form_id' => $search_form_id, 'search_result_id' => $search_result_id]) ?>
<?= SearchResultWidget::widget(['results' => $results, 'search_result_id' => $search_result_id]) ?>
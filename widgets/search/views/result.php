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
use yii\widgets\Pjax;
use rhoone\widgets\search\result\ContainerWidget;
use rhoone\widgets\search\result\FormWidget;

/* @var $pjaxConfig array */
/* @var $containerConfig array */
/* @var $formConfig array */

$pjax = Pjax::begin($pjaxConfig);
echo ContainerWidget::widget(['containerConfig' => $containerConfig]);
echo FormWidget::widget(['formConfig' => $formConfig]);
Pjax::end();

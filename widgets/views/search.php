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
use rhoone\widgets\search\assets\SearchAsset;
use rhoone\widgets\search\PanelWidget;
use rhoone\widgets\search\ResultWidget;

SearchAsset::register($this);

/* @var $panelConfig array */
echo PanelWidget::widget($panelConfig);
/* @var $resultConfig array */
echo ResultWidget::widget($resultConfig);

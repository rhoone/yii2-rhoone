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

namespace rhoone\widgets\search\panel;

use yii\base\Widget;

/**
 * Description of FormWidget
 *
 * @author vistart <i@vistart.name>
 */
class FormWidget extends Widget
{

    public function run()
    {
        return $this->render('form');
    }
}

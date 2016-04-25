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

namespace rhoone\tests\base;

use rhoone\base\Rhoone;
use rhoone\tests\TestCase;
use Yii;

/**
 * Description of RhooneTest
 *
 * @author vistart <i@vistart.name>
 */
class RhooneTest extends TestCase
{

    public function testLoad()
    {
        $rhoone = Yii::$app->rhoone;
        $this->assertInstanceOf(Rhoone::className(), $rhoone);
    }
}

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

use rhoone\base\DictionaryManager;
use rhoone\base\Rhoone;
use rhoone\tests\TestCase;
use Yii;

/**
 * Description of DictionaryManager
 *
 * @author vistart <i@vistart.name>
 */
class DictionaryManagerTest extends TestCase
{

    public function testRhoone()
    {
        $rhoone = Yii::$app->rhoone;
        $this->assertInstanceOf(Rhoone::className(), $rhoone);
    }

    /**
     * @depends testRhoone
     */
    public function testLoad()
    {
        $dicMgr = Yii::$app->rhoone->dic;
        $this->assertInstanceOf(DictionaryManager::className(), $dicMgr);
    }
}

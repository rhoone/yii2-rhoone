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

namespace rhoone\tests\models;

use rhoone\base\KeywordSegmenter;
use rhoone\models\Keyword;
use rhoone\tests\TestCase;
use Yii;

/**
 * Description of KeywordTest
 *
 * @author vistart <i@vistart.name>
 */
class KeywordTest extends TestCase
{

    /**
     * @group keyword
     */
    public function testInit()
    {
        $keyword = new Keyword();
        $this->assertInstanceOf(Keyword::className(), $keyword);
    }

    /**
     * @depends testInit
     */
    public function testNonKeyword()
    {
        $keyword = new Keyword();
        $this->assertEquals("", (string) $keyword);
        $this->assertEquals("", $keyword->raw);
    }

    /**
     * @depends testNonKeyword
     */
    public function testNonKeywordSegment()
    {
        $keyword = new Keyword();
        $this->assertInstanceOf(KeywordSegmenter::className(), $keyword->segmenter);
        $this->assertEquals([], $keyword->segmented);
        $this->assertEquals(['raw' => "", "segmented" => []], $keyword->keyword);
    }

    /**
     * @depends testInit
     */
    public function testRandomKeyword()
    {
        $randomKeyword = Yii::$app->security->generateRandomString(12);
        $keyword = new Keyword($randomKeyword);
        $this->assertEquals($randomKeyword, (string) $keyword);
        $this->assertEquals($randomKeyword, $keyword->raw);
    }

    /**
     * @depends testRandomKeyword
     */
    public function testRandomKeywordSegment()
    {
        $randomKeyword = Yii::$app->security->generateRandomString(12);
        $keyword = new Keyword($randomKeyword);
        $this->assertEquals([$randomKeyword], $keyword->segmented);
        $this->assertEquals(['raw' => $randomKeyword, 'segmented' => [$randomKeyword]], $keyword->keyword);
    }
}

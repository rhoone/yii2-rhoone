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

namespace rhoone\base;

use rhoone\extension\SegmenterInterface;
use yii\base\Component;

/**
 * Description of SegmenterInterface
 *
 * @author vistart <i@vistart.name>
 */
class KeywordSegmenter extends Component implements SegmenterInterface
{

    /**
     * 
     * @param string $keyword
     * @return string[] $keywords
     */
    public function segment($keyword)
    {
        return (array) $keyword;
    }
}

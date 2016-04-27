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

use rhoone\extension\SplitterInterface;
use yii\base\Component;

/**
 * Description of KeywordSplitter
 *
 * @author vistart <i@vistart.name>
 */
class KeywordSplitter extends Component implements SplitterInterface
{

    /**
     * 
     * @param string $keyword
     * @return string[] $keywords
     */
    public function split($keyword)
    {
        return (array) $keyword;
    }
}

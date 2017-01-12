<?php

/**
 *  _   __ __ _____ _____ ___  ____  _____
 * | | / // // ___//_  _//   ||  __||_   _|
 * | |/ // /(__  )  / / / /| || |     | |
 * |___//_//____/  /_/ /_/ |_||_|     |_|
 * @link https://vistart.me/
 * @copyright Copyright (c) 2016 - 2017 vistart
 * @license https://vistart.me/license/
 */

namespace rhoone\extension;

/**
 * Segmenter Interface
 *
 * @author vistart <i@vistart.me>
 */
Interface SegmenterInterface
{

    /**
     * Split the keyword into seperated keywords.
     * @param string $keyword Raw keyword string.
     * If it is not a string, please return empty array.
     * @return string[] Seperated keywords.
     */
    public function segment($keyword);
}

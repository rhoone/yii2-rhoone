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

namespace rhoone\extension;

/**
 * Segmenter Interface
 *
 * @author vistart <i@vistart.name>
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

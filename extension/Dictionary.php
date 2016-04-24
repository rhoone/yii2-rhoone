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

use yii\base\Model;

/**
 * Description of Dictionary
 *
 * @author vistart <i@vistart.name>
 */
abstract class Dictionary extends Model
{

    /**
     * Dictionary array example:
     * ```
     * [
     *     [
     *         0 => 'word1',    // Headword, required, it's key must be 0.
     *         'word2',         // The others are synonyms to headword.
     *         ...
     *     ],
     *     ...
     * ]
     * ```
     * If your extension don't provide any words, please return null.
     * @return array
     */
    public function getDictionary()
    {
        return null;
    }
}

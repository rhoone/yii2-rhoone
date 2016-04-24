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

use yii\base\InvalidParamException;

/**
 * Description of DictionaryHelperTrait
 *
 * @author vistart <i@vistart.name>
 */
trait DictionaryHelperTrait
{

    /**
     * 
     * @param array $dictionary
     */
    public static function add($dictionary)
    {
        static::validate($dictionary);
    }
    
    public static function addHeadword($word)
    {
        
    }
    
    public static function addSynonyms($headword, $synonyms)
    {
        
    }

    /**
     * Validate dictionary.
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
     * @param array $dictionary
     * @return boolean True if validated.
     * @throws InvalidParamException if error occured.
     */
    public static function validate($dictionary)
    {
        if (!is_array($dictionary)) {
            throw new InvalidParamException("Invalid dictionary.");
        }
        foreach ($dictionary as $key => $words) {
            if (!is_array($words)) {
                throw new InvalidParamException("Invalid Words.");
            }
            $headword = null;
            foreach ($words as $key => $synonyms) {
                if (!is_string($synonyms)) {
                    throw new InvalidParamException("Invalid Synonyms.");
                }
                if (strlen($synonyms) == 0 || strlen($synonyms) > 255) {
                    throw new InvalidParamException("The length of synonyms exceeds the limit.");
                }
                if ($key == 0) {
                    $headword = $synonyms;
                }
            }
            if (!is_string($headword)) {
                throw new InvalidParamException("Invalid headword.");
            }
        }
        return true;
    }
}

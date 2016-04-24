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
     * @param array|\rhoone\extension\Dictionary|string|\rhoone\extension\Extension $dictionary
     * `array`: dictionary array.
     * `\rhoone\extension\Dictionary`: dictionary model.
     * `string`: extension class string.
     * `\rhoone\extension\Extension`: extension model.
     * @return boolean True if validated.
     * @throws InvalidParamException if error occured.
     */
    public static function validate($dictionary)
    {
        if (is_array($dictionary)) {
            return static::validateArray($dictionary);
        }
        if ($dictionary instanceof \rhoone\extension\Dictionary) {
            return static::validateArray($dictionary->getDictionary());
        }
        if (is_string($dictionary)) {
            $class = ExtensionManager::normalizeClass($dictionary);
            $dictionary = new $class();
        }
        if ($dictionary instanceof \rhoone\extension\Extension) {
            return static::validateWithExtension($dictionary);
        }
        return false;
    }

    /**
     * 
     * @param array $dictionary
     * @return boolean
     * @throws InvalidParamException
     */
    public static function validateArray($dictionary)
    {
        if (!is_array($dictionary)) {
            throw new InvalidParamException("Invalid dictionary array.");
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
    
    /**
     * 
     * @param \rhoone\extension\Extension $extension
     * @return boolean
     */
    public static function validateWithExtension($extension)
    {
        return static::validateArray($extension->getDictionary()->getDictionary());
    }
}

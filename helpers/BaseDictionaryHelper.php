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

namespace rhoone\helpers;

use rhoone\models\Extension;
use rhoone\models\Headword;
use rhoone\models\Synonyms;
use yii\base\InvalidParamException;
use Yii;

/**
 * Description of BaseDictionaryHelper
 *
 * @author vistart <i@vistart.name>
 */
class BaseDictionaryHelper
{

    /**
     * 
     * @param mixed $dictionary
     * @return true
     * @throws InvalidParamException
     */
    public static function validate($dictionary)
    {
        if (is_array($dictionary)) {
            return static::validateArray($dictionary);
        }
        if ($dictionary === null) {
            return true;
        }
        throw new InvalidParamException("Dictionary invalid.");
    }

    /**
     * 
     * @param mixed $dictionary
     * @return boolean
     */
    public static function validateArray($dictionary)
    {
        foreach ($dictionary as $headword => $synonyms) {
            if (!is_string($headword)) {
                Yii::error($headword . 'is not string.', __METHOD__);
                unset($dictionary[$headword]);
                continue;
            }
            if (!is_array($synonyms) && is_string($synonyms)) {
                $synonyms = (array) $synonyms;
            } else {
                Yii::error($headword . ' does not contain any valid synonyms.', __METHOD__);
            }
            foreach ($synonyms as $key => $syn) {
                if (!is_string($syn)) {
                    unset($synonyms[$key]);
                    Yii::error($headword . ' contains an invalid synonyms.' . __METHOD__);
                }
            }
        }
        return $dictionary;
    }

    public static function get()
    {
        
    }

    /**
     * 
     * @param string|string[] $keywords
     * @return \rhoone\models\Synonyms[]
     */
    public static function match($keywords)
    {
        if (is_string($keywords)) {
            $keywords = (array) $keywords;
        }
        return \rhoone\models\Synonyms::find()->word($keywords)->all();
    }

    /**
     * 
     * @param Extension $extension
     * @param array $dictionary
     * @return boolean
     */
    public static function add($extension, $dictionary)
    {
        try {
            if (!static::validate($dictionary)) {
                throw new InvalidParamException('Dictionary invalid.');
            }
            if (is_array($dictionary)) {
                $validatedDic = static::validateArray($dictionary);
                foreach ($validatedDic as $word => $synonyms) {
                    $headword = Headword::add($word, $extension);
                    if (!$headword) {
                        Yii::error($word . ' failed to add.', __METHOD__);
                        continue;
                    }
                    $headword->synonyms = $synonyms;
                }
            }
        } catch (Exception $ex) {
            return false;
        }
        return true;
    }

    /**
     * 
     * @param Extension $extension
     * @param string $word
     */
    public static function addHeadword($extension, $word)
    {
        return $extension->setHeadword($word);
    }

    /**
     * 
     * @param Extension $extension
     * @param string|Headword $word
     */
    public static function removeHeadword($extension, $word)
    {
        return $extension->removeHeadword($word);
    }

    /**
     * 
     * @param Extension $extension
     */
    public static function removeAllHeadwords($extension)
    {
        return $extension->removeAllHeadwords();
    }
}

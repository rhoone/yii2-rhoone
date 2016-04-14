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
        throw new InvalidParamException("Dictionary invalid.");
    }

    /**
     * 
     * @param mixed $dictionary
     * @return boolean
     */
    public static function validateArray($dictionary)
    {
        foreach ($dictionary as $headword => $synonmys) {
            if (!is_string($headword)) {
                Yii::error($headword . 'is not string.', __METHOD__);
                unset($dictionary[$headword]);
                continue;
            }
            if (!is_array($synonmys) && is_string($synonmys)) {
                $synonmys = (array) $synonmys;
            } else {
                Yii::error($headword . ' does not contain any valid synonmys.', __METHOD__);
            }
            foreach ($synonmys as $key => $syn) {
                if (!is_string($syn)) {
                    unset($synonmys[$key]);
                    Yii::error($headword . ' contains an invalid synonmys.' . __METHOD__);
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
     * @param Extension $extension
     * @param string $keywords
     * @return
     */
    public static function match($extension, $keywords)
    {
        
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
                foreach ($validatedDic as $word) {
                    $headword = \rhoone\models\Headword::add($word, $extension);
                    if (!$headword) {
                        Yii::error($word . ' failed to add.', __METHOD__);
                        continue;
                    }
                    
                }
            }
        } catch (Exception $ex) {
            return false;
        }
        return true;
    }
}

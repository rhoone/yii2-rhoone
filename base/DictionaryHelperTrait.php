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

use Yii;
use yii\base\InvalidParamException;

/**
 * Description of DictionaryHelperTrait
 *
 * @author vistart <i@vistart.name>
 */
trait DictionaryHelperTrait
{

    /**
     * Add dictionary to extension.
     * @param string|\rhoone\extension\Extension|\rhoone\models\Extension $extension
     * @param array|\rhoone\extension\Dictionary|string|\rhoone\extension\Extension|null $dictionary
     */
    public static function add($extension, $dictionary = null)
    {
        $extension = ExtensionManager::validate($extension);
        if ($dictionary === null) {
            $dictionary = $extension->getDictionary();
        }
        $dictionary = static::validate($dictionary);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($dictionary as $words) {
                $headword = $words[0];
                $headword = static::addHeadword($extension, $headword);
                if (!($headword instanceof \rhoone\models\Headword) || !$headword) {
                    throw new InvalidParamException("Failed to add headword.");
                }
                foreach ($words as $key => $synonyms) {
                    if (!$headword->setSynonyms($synonyms)) {
                        throw new InvalidParamException("Failed to add synonyms. It's headword is `" . $headword->word . "`.");
                    }
                }
            }
            $transaction->commit();
        } catch (\Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }
        return true;
    }

    /**
     * Add headword.
     * @param string|\rhoone\extension\Extension|\rhoone\models\Extension $extension
     * @param string|\rhoone\models\Headword $word
     * @return false|\rhoone\models\Headword
     */
    public static function addHeadword($extension, $word)
    {
        $extension = ExtensionManager::getModel($extension);
        return $extension->setHeadword($word);
    }

    /**
     * Add synonyms.
     * @param string|\rhoone\extension\Extension|\rhoone\models\Extension $extension
     * `string`: Extension class name.
     * `\rhoone\extension\Extension`: Extension model.
     * `\rhoone\models\Extension`: Extension
     * @param string|\rhoone\models\Headword $headword
     * `string`: Headword string.
     * `\rhoone\models\Headword`: Headword model.
     * @param string|string[]|Synonyms|Synonyms[] $synonyms
     * @return boolean
     */
    public static function addSynonyms($extension, $headword, $synonyms)
    {
        $extension = ExtensionManager::getModel($extension);
        if (is_string($headword)) {
            $headword = $extension->getHeadwords()->andWhere(['word' => $headword])->one();
            if (!$headword) {
                return false;
            }
        }
        if ($headword instanceof \rhoone\models\Headword) {
            return $headword->setSynonyms($synonyms);
        }
        return false;
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
     * @return array|false Dictionary array if validated, or false if invalid.
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
     * @return array
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
        return $dictionary;
    }

    /**
     * 
     * @param \rhoone\extension\Extension $extension
     * @return array
     */
    public static function validateWithExtension($extension)
    {
        return static::validateArray($extension->getDictionary()->getDictionary());
    }
}

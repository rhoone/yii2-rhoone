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

use rhoone\base\ExtensionManager;
use rhoone\models\Headword;
use rhoone\models\Synonym;
use yii\base\InvalidParamException;
use yii\di\ServiceLocator;

/**
 * Dictionary Manager
 *
 * @property-read Headword[] $headwords
 * @property-read Synonym[] $synonyms
 * @author vistart <i@vistart.name>
 */
class DictionaryManager extends ServiceLocator
{
    use DictionaryHelperTrait;

    /**
     * Headwords generator.
     * @param string|\rhoone\extension\Extension|\rhoone\models\Extension|mixed $class
     * `string` if extension class.
     * @param string[] $words
     * @throws InvalidParamException
     */
    public function getHeadwords($class = null, $words = [])
    {
        // Method One:
        if ($class === null || $class === false || (is_string($class) && empty($class))) {
            $query = Headword::find();
        } else {
            $extensions = ExtensionManager::getModels($class);
            $guids = [];
            foreach ($extensions as $extension) {
                $guids[] = $extension->guid;
            }
            $query = Headword::find()->guid($guids);
        }
        if (is_array($words) && !empty($words)) {
            $query = $query->word($words);
        }
        foreach ($query->all() as $headword) {
            yield $headword;
        }
        // Method Two:
        //return Headword::find()->all();
    }

    /**
     * Synonyms generator.
     * @param string|\rhoone\extension\Extension|\rhoone\models\Extension|mixed $class
     * `string` if extension class.
     * @param string[] $words
     * @throws InvalidParamException
     */
    public function getSynonyms($class = null, $words = [])
    {
        // Method One:
        $query = Synonym::find();
        if (is_array($words) && !empty($words)) {
            $query = $query->word($words);
        }
        if (!($class === null || $class === false || (is_string($class) && empty($class)))) {
            $query = $query->extension($class);
        }
        foreach ($query->all() as $synonyms) {
            yield $synonyms;
        }
        // Method Two:
        //return Synonym::find()->all();
    }

    /**
     * 
     * @param string|string[]|Keyword $keywords
     */
    public function match($keywords = "")
    {
        if (is_string($keywords)) {
            $keywords = (array) $keywords;
        }
        if ($keywords instanceof Keyword) {
            $keywords = $keywords->splitted;
        }
        foreach ($keywords as $key => $keyword) {
            if (!is_string($keyword)) {
                unset($keywords[$key]);
            }
        }
    }
}

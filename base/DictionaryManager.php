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
use rhoone\models\Synonyms;
use yii\base\InvalidParamException;
use yii\di\ServiceLocator;

/**
 * Dictionary Manager
 *
 * @property-read Headword[] $headwords
 * @property-read Synonyms[] $synonyms
 * @author vistart <i@vistart.name>
 */
class DictionaryManager extends ServiceLocator
{
    use DictionaryHelperTrait;

    /**
     * Headwords generator.
     * @param string $class
     * `string` if extension class.
     * @throws InvalidParamException
     */
    public function getHeadwords($class = null)
    {
        // Method One:
        if ($class === null || $class === false || (is_string($class) && empty($class))) {
            foreach (Headword::find()->all() as $headword) {
                yield $headword->word;
            }
        } else {
            $extension = ExtensionManager::getModel($class);
            foreach ($extension->getHeadwords()->all() as $headword) {
                yield $headword->word;
            }
        }
        // Method Two:
        //return Headword::find()->all();
    }

    /**
     * Synonyms generator.
     * @param string $class
     * `string` if extension class.
     * @throws InvalidParamException
     */
    public function getSynonyms($class = null)
    {
        // Method One:
        if ($class === null || $class === false || (is_string($class) && empty($class))) {
            foreach (Synonyms::find()->all() as $synonyms) {
                yield $synonyms->word;
            }
        } else {
            $extension = ExtensionManager::getModel($class);
            foreach ($extension->getSynonyms()->all() as $synonyms) {
                yield $synonyms->word;
            }
        }
        // Method Two:
        //return Synonyms::find()->all();
    }
}

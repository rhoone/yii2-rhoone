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

namespace rhoone\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;

/**
 * Manage Dictionaries.
 *
 * @author vistart <i@vistart.name>
 */
class DictionaryController extends Controller
{

    /**
     * Validate dictionary of extension.
     * @param string $class The extension class.
     * @return int
     * @throws Exception if error(s) occured.
     */
    public function actionValidate($class)
    {
        try {
            Yii::$app->rhoone->dic->validate($class);
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        echo "No errors occured.";
        return 0;
    }

    /**
     * List all headwords.
     * @param string $class
     * @return int
     */
    public function actionHeadwords($class = null)
    {
        try {
            foreach (Yii::$app->rhoone->dic->getHeadwords($class) as $headword) {
                echo $headword->word . "\n";
            }
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        return 0;
    }

    /**
     * List all synonyms.
     * @param string $class
     * @return int
     */
    public function actionSynonyms($class = null)
    {
        try {
            foreach (Yii::$app->rhoone->dic->getSynonyms($class) as $synonyms) {
                echo $synonyms->word . "\n";
            }
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        return 0;
    }
}

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

use rhoone\helpers\ExtensionHelper;
use rhoone\models\Headword;
use yii\console\Controller;
use yii\console\Exception;

/**
 * Manage Extensions
 *
 * @author vistart <i@vistart.name>
 */
class ExtensionController extends Controller
{

    /**
     * List all registered extensions.
     * @return int
     */
    public function actionIndex()
    {
        $extensions = ExtensionHelper::all();
        if (empty($extensions)) {
            echo "<empty list>";
        }
        return 0;
    }

    /**
     * Add an extension.
     * @param string $class Full-qualified name of a extension.
     * @param boolean $enable Whether enable the module after adding it.
     * @return int
     */
    public function actionAdd($class, $enable = false)
    {
        try {
            $result = ExtensionHelper::add($class, $enable);
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        echo "The extension `" . $class . "` is added.\n";
        return 0;
    }

    /**
     * Enable an extension.
     * @param string $class
     * @return int
     */
    public function actionEnable($class)
    {
        return 0;
    }

    /**
     * Disable an extension.
     * @param string $class
     * @return int
     */
    public function actionDisable($class)
    {
        return 0;
    }

    /**
     * Remove an extension
     * @param string $class
     * @param boolean $force
     * @return int
     * @throws Exception
     */
    public function actionRemove($class, $force = false)
    {
        try {
            $result = ExtensionHelper::remove($class, $force);
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        echo "The extension `" . $class . "` is removed.\n";
        return 0;
    }

    /**
     * Add headword to class.
     * @param string $class
     * @param string $word
     * @throws Exception
     */
    public function actionAddHeadword($class, $word)
    {
        $model = ExtensionHelper::getModel($class);
        if (!$model) {
            throw new Exception('`' . $class . '` does not exist.');
        }
        try {
            $model->headword = $word;
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        return 0;
    }

    /**
     * Remove headword.
     * @param string $class
     * @param string $word
     */
    public function actionRemoveHeadword($class, $word)
    {
        
    }

    /**
     * Add synonyms to class.
     * @param string $class
     * @param string $headword
     * @param string $word
     * @param boolean $addMissing
     */
    public function actionAddSynonyms($class, $headword, $word, $addMissing = true)
    {
        $model = ExtensionHelper::getModel($class);
        if (!$model) {
            throw new Exception('`' . $class . '` does not exist.');
        }
        $headwordModel = $model->getHeadwords()->andWhere(['word' => $headword])->one();
        if (!$headwordModel) {
            if ($addMissing) {
                $headwordModel = $model->setHeadword(new Headword(['word' => $headword]));
            } else {
                throw new Exception('The headword: `' . $headword . '` does not exist.');
            }
        }
        try {
            if (!$headwordModel->setSynonyms($word)) {
                throw new Exception('Failed to add synonyms: `' . $word . '`');
            }
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        echo "The synonyms `" . $word . "` is added to `" . $class . "`";
        return 0;
    }

    /**
     * Remove synonyms.
     * @param string $class
     * @param string $headword
     * @param string $word
     */
    public function actionRemoveSynonyms($class, $headword, $word)
    {
        
    }

    /**
     * Match headword.
     * @param string $class
     * @param string $word
     */
    public function actionMatchHeadword($class, $word)
    {
        
    }

    /**
     * Match synonyms.
     * @param string $class
     * @param string $word
     */
    public function actionMatchSynonyms($class, $word)
    {
        
    }
}

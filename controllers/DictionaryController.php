<?php

/**
 *  _   __ __ _____ _____ ___  ____  _____
 * | | / // // ___//_  _//   ||  __||_   _|
 * | |/ // /(__  )  / / / /| || |     | |
 * |___//_//____/  /_/ /_/ |_||_|     |_|
 * @link https://vistart.me/
 * @copyright Copyright (c) 2016 - 2017 vistart
 * @license https://vistart.me/license/
 */

namespace rhoone\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;

/**
 * Manage Dictionaries.
 *
 * @author vistart <i@vistart.me>
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

    /**
     * Add headword to class.
     * @param string $class
     * @param string $word
     * @throws Exception
     */
    public function actionAddHeadword($class, $word)
    {
        $extMgr = Yii::$app->rhoone->ext;
        /* @var $extMgr \rhoone\base\ExtensionManager */
        $model = $extMgr->getModel($class);
        if (!$model) {
            throw new Exception('`' . $class . '` does not exist.');
        }
        try {
            $result = $model->setHeadword($word, true);
            echo ($result ? "$word added." : "Failed to add.");
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
        $extMgr = Yii::$app->rhoone->ext;
        /* @var $extMgr \rhoone\base\ExtensionManager */
        $model = $extMgr->getModel($class);
        if (!$model) {
            throw new Exception('`' . $class . '` does not exist.');
        }
        try {
            $headword = $model->getHeadwords()->andWhere(['word' => $word])->one();
            if (!$headword) {
                echo "`$word` does not exist.";
                return 0;
            }
            echo ($headword->delete() ? "$word deleted." : "Failed to delete.");
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        return 0;
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
        $extMgr = Yii::$app->rhoone->ext;
        /* @var $extMgr \rhoone\base\ExtensionManager */
        $model = $extMgr->getModel($class);
        $headwordModel = $model->getHeadwords()->andWhere(['word' => $headword])->one();
        if (!$headwordModel) {
            if ($addMissing) {
                $headwordModel = $model->setHeadword(new Headword(['word' => $headword]));
            } else {
                throw new Exception("The headword: `" . $headword . "` does not exist.");
            }
        }
        try {
            if (!$headwordModel->setSynonyms($word)) {
                throw new Exception("Failed to add synonyms: `" . $word . "`");
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
        $extMgr = Yii::$app->rhoone->ext;
        /* @var $extMgr \rhoone\base\ExtensionManager */
        $model = $extMgr->getModel($class);
        $headwordModel = $model->getHeadwords()->andWhere(['word' => $headword])->one();
        /* @var $headwordModel \rhoone\models\Headword */
        if (!$headwordModel) {
            throw new Exception('The headword: `' . $headword . '` does not exist.');
        }
        try {
            if (!$headwordModel->removeSynonyms($word)) {
                throw new Exception("Failed to remove synonyms: `" . $word . "'");
            }
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        echo "The synonyms `$word` removed.";
        return 0;
    }
}

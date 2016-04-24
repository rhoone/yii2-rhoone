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
use Yii;
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
        echo"|";
        echo sprintf("%28s", "Class Name");
        echo"|";
        echo sprintf("%4s", "Enb");
        echo"|";
        echo sprintf("%4s", "Mnp");
        echo"|";
        echo sprintf("%4s", "Dft");
        echo"|";
        echo sprintf("%20s", "Create Time");
        echo"|";
        echo sprintf("%20s", "Update Time");
        echo"|";
        echo "\r\n";
        foreach ($extensions as $extension) {
            echo"|";
            echo sprintf("%28s", $extension->classname);
            echo"|";
            echo sprintf("%4d", $extension->isEnabled);
            echo"|";
            echo sprintf("%4d", $extension->monopolized);
            echo"|";
            echo sprintf("%4d", $extension->default);
            echo"|";
            echo sprintf("%20s", $extension->createdAt);
            echo"|";
            echo sprintf("%20s", $extension->updatedAt);
            echo"|";
            echo "\r\n";
        }
        return 0;
    }

    /**
     * Register an extension.
     * @param string $class Full-qualified name of a extension.
     * @param boolean $enable Whether enable the module after adding it.
     * @return int
     */
    public function actionRegister($class, $enable = false)
    {
        try {
            $result = Yii::$app->rhoone->ext->register($class, $enable);
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
        try {
            if (Yii::$app->rhoone->ext->enable($class)) {
                echo "Enabled.";
            } else {
                echo "Failed to enable.";
            }
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        return 0;
    }

    /**
     * Disable an extension.
     * @param string $class
     * @return int
     */
    public function actionDisable($class)
    {
        try {
            if (Yii::$app->rhoone->ext->disable($class)) {
                echo "Disabled.";
            } else {
                echo "Failed to disable.";
            }
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        return 0;
    }

    /**
     * Validate extension.
     * @param string $class
     * @return int
     * @throws Exception
     */
    public function actionValidate($class)
    {
        try {
            Yii::$app->rhoone->ext->validate($class);
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }
        echo "No errors occured.";
        return 0;
    }

    /**
     * Validate dictionary of extension.
     * @param string $class
     * @return int
     * @throws Exception
     */
    public function actionValidateDictionary($class)
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
     * Remove an extension
     * @param string $class
     * @param boolean $force
     * @return int
     * @throws Exception
     */
    public function actionRemove($class, $force = false)
    {
        try {
            Yii::$app->rhoone->ext->deregister($class, $force);
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
    public function actionMatchSynonyms($class, $word = null)
    {
        $model = ExtensionHelper::getModel($class);
        if (!$model) {
            throw new Exception('`' . $class . '` does not exist.');
        }
        foreach ($model->synonyms as $synonyms) {
            echo $synonyms->word . "\r\n";
        }
        return 0;
    }

    /**
     * 
     * @param string $class
     */
    public function actionExist($class)
    {
        $model = ExtensionHelper::getModel($class);
        if ($model) {
            echo "`$class` existed.";
        } else {
            echo "`$class` does not exist.";
        }
        return 0;
    }
}

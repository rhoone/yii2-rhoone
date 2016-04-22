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

use rhoone\extensions\Dictionary as ExternalDic;
use rhoone\extensions\Extension as ExternalExt;
use rhoone\extensions\Server as ExternalServer;
use rhoone\models\Extension;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use Yii;

/**
 * Description of BaseExtensionHelper
 *
 * @author vistart <i@vistart.name>
 */
class BaseExtensionHelper
{

    /**
     * Get all registered extensions.
     * @return Extension[]
     */
    public static function all()
    {
        return Extension::find()->all();
    }

    /**
     * Get all registered extensions which is enabled.
     * @return Extension[]
     */
    public static function allEnabledModels()
    {
        return Extension::findAllEnabled();
    }

    /**
     * Get all enabled external extensions.
     * @return ExternalExt[]
     */
    public static function allEnabled()
    {
        $exts = static::allEnabledModels();
        $extensions = [];
        foreach ($exts as $ext) {
            try {
                $extension = static::get($ext->classname);
            } catch (\Exception $ex) {
                Yii::error($ex->getMessage());
                continue;
            }
            $extensions[] = $extension;
        }
        return $extensions;
    }

    /**
     * Register external extension.
     * @param string $class External extension class name.
     * @param boolean $enable
     * @return boolean
     * @throws InvalidParamException
     */
    public static function add($class, $enable = false)
    {
        $extension = static::validate($class);

        unset($class);
        $class = $extension->className();
        $name = $extension->name();
        $id = $extension->id();

        if (Extension::find()->where(['classname' => $class])->exists()) {
            throw new InvalidParamException('the class `' . $class . '` has been added.');
        }

        $dic = $extension->getDictionary();

        unset($extension);
        $extension = new Extension(['id' => $id, 'classname' => $class, 'name' => $name, 'enabled' => $enable == true]);
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            if (!$extension->save()) {
                throw new InvalidParamException('`' . $class . '` failed to added.');
            }
            if (!$extension->addDictionary($dic)) {
                throw new InvalidParamException('`' . $class . '');
            }
            $transaction->commit();
        } catch (\Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }
        return true;
    }

    /**
     * Enable external extension.
     * @param string $class External extension class name.
     * @return boolean
     * @throws InvalidParamException
     * @throws InvalidConfigException
     */
    public static function enable($class)
    {
        $extension = static::validate($class);
        $enabledExt = Extension::find()->where(['classname' => $extension->className()])->one();
        if (!$enabledExt) {
            throw new InvalidParamException("`" . $extension->className() . "` has not been added yet.\n");
        }
        if ($enabledExt->isEnabled) {
            throw new InvalidParamException("`" . $extension->className() . "` has been enabled.\n");
        }
        $enabledExt->isEnabled = true;
        if (!$enabledExt->save()) {
            throw new InvalidConfigException("`" . $extension->className() . "` failed to enable.\n");
        }
        echo "`" . $extension->className() . "` is enabled.\n";
        return true;
    }

    /**
     * Disable external extension.
     * @param string $class External extension class name.
     * @return boolean
     * @throws InvalidParamException
     * @throws InvalidConfigException
     */
    public static function disable($class)
    {
        $extension = static::validate($class);
        $enabledExt = Extension::find()->where(['classname' => $extension->className()])->one();
        if (!$enabledExt) {
            throw new InvalidParamException("~" . $extension->className() . "` has not been added yet.\n");
        }
        if (!$enabledExt->isEnabled) {
            throw new InvalidParamException("`" . $extension->className() . "` has been disabled.\n");
        }
        $enabledExt->isEnabled = false;
        if (!$enabledExt->save()) {
            throw new InvalidConfigException("`" . $extension->className() . "` failed to disable.\n");
        }
        echo "`" . $extension->className() . "` is disabled.\n";
        return true;
    }

    /**
     * Get external extension.
     * @param string $class External extension class name.
     * @return ExternalExt
     * @throws InvalidParamException
     */
    public static function get($class)
    {
        $extension = static::validate($class);
        $enabledExt = Extension::find()->where(['classname' => $extension->className()])->enabled(true)->one();
        if (!$enabledExt) {
            throw new InvalidParamException("`" . $extension->className() . "` has not been enabled.\n");
        }
        return $extension;
    }

    /**
     * Get registered extension.
     * @param string $class External extension class name.
     * @return Extension
     */
    public static function getModel($class)
    {
        $extension = static::validate($class);
        $model = Extension::findOne(['classname' => $extension->className()]);
        return $model;
    }

    /**
     * Validate external extension.
     * It will throw exception if error(s) occured.
     * @param string $class External extension class name.
     * @return ExternalExt
     * @throws InvalidParamException
     */
    public static function validate($class)
    {
        if (!is_string($class)) {
            Yii::error('the class name is not a string.', __METHOD__);
            throw new InvalidParamException('the class name is not a string.');
        }
        Yii::trace('validate extension: `' . $class . '`', __METHOD__);

        if (!class_exists($class)) {
            if (strpos($class, "\\", strlen($class) - 1) === false) {
                $class .= "\Extension";
            } else {
                $class .= "Extension";
            }
        }
        if (!class_exists($class)) {
            throw new InvalidParamException('the class `' . $class . '` does not exist.');
        }

        $extension = new $class();
        $class = $extension->className();
        if (!($extension instanceof \rhoone\extension\Extension)) {
            throw new InvalidParamException('the class `' . $class . '` is not an extension.');
        }

        $dic = $extension->getDictionary();
        if (empty($dic)) {
            Yii::warning("`$class` does not contain a dictionary.\n", __METHOD__);
        } else {
            
        }

        return $extension;
    }

    /**
     * Deregister external extension.
     * @param string $class External extension class name.
     * @param boolean $force
     * @return boolean
     * @throws InvalidParamException
     */
    public static function remove($class, $force)
    {
        $extension = static::validate($class);
        unset($class);
        $class = $extension->className();
        unset($extension);
        $extension = Extension::find()->where(['classname' => $class])->one();
        if (!$extension) {
            throw new InvalidParamException('the class `' . $class . '` has not been added yet.');
        }
        return $extension->delete() == 1;
    }

    /**
     * Get all registered extensions which is default.
     * @param boolean $enabled
     * @param boolean $monopolized
     * @param mixed $except
     * @return Extension[]
     */
    public static function allDefaultModels($enabled = null, $monopolized = null, $except = null)
    {
        $query = Extension::find()->isDefault()->enabled($enabled)->monopolized($monopolized);
        if (!empty($except) && is_array($except)) {
            $noModel = Extension::buildNoInitModel();
            $query = $query->andWhere(['not in', $noModel->guidAttribute, $except]);
        }
        return $query->all();
    }

    /**
     * Get all matched external extensions (include default extensions).
     * @param mixed $keywords Normalized keywords.
     * @param Extension|Extension[] $extensions
     * @return ExternalExt[]
     */
    public static function allMatched($keywords, $extensions = null)
    {
        $exts = [];
        $extGuids = [];
        $matchedSynonyms = DictionaryHelper::match($keywords);
        Yii::info("matched synonyms count: " . count($matchedSynonyms), __METHOD__);
        foreach ($matchedSynonyms as $key => $synonyms) {
            Yii::info("matched synonyms: `" . $synonyms->word . "`(" . $synonyms->guid . ")", __METHOD__);
            $extension = $synonyms->extension;
            $classname = $extension->classname;
            Yii::info("matched class name: `" . $classname . "`", __METHOD__);
            if (!$extension->isEnabled) {
                Yii::warning("But it is not enabled.");
                continue;
            }
            $exts[] = new $classname();
            $extGuids[] = $extension->guid;
        }
        $defaults = static::allDefaultModels(true, null, $extGuids);
        foreach ($defaults as $default) {
            $classname = $default->classname;
            Yii::info("default class name: `" . $classname . "`", __METHOD__);
            $exts[] = new $classname();
            $extGuids[] = $default->guid;
        }
        return $exts;
    }

    /**
     * Search by the extensions.
     * @param string|integer|string[] $keywords Search keywords.
     * If this parameter is a string, we will analyze the semantics of it,
     * then split it into an array of words.
     * If this parameter is an array of string, we believe that the array is already
     * an array of words no longer be segmented.
     * If neither a string nor an array of strings, no search will be processed,
     * directly return null.
     * Note: Number (numeric or string) is not semantically segmanted,
     * the number will directly convert to numeric string.
     * If number appears in keywords array, it will be converted to string;
     * if another type appears in keywords array, it will be skipped.
     * @param Extension|Extension[]|null $extensions Extensions used to search.
     * If you do not want to limit the extensions, please assign `null`.
     * If you assign an empty array, no search will be processed.
     * @return array|null
     */
    public static function search($keywords, $extensions = null)
    {
        Yii::trace("Begin searching...", __METHOD__);
        if (!is_string($keywords) || strlen($keywords) == 0) {
            Yii::warning('Empty keywords!', __METHOD__);
            return null;
        }
        $exts = static::allMatched($keywords, $extensions);
        $results = [];
        foreach ($exts as $ext) {
            $results[] = $ext->search($keywords);
        }
        return $results;
    }
}

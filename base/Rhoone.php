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

use rhoone\extension\Extension;
use rhoone\models\Keyword;
use Yii;
use yii\di\ServiceLocator;

/**
 * Rhoone component.
 *
 * @property-read ExtensionManager $ext Extension Manager.
 * @property-read DictionaryManager $dic Dictionary Manager.
 * @property-read Extension[] $extensions Loaded extension instances,
 * if ExtensionManager is one of the core components and it was loaded correctly.
 * @author vistart <i@vistart.name>
 */
class Rhoone extends ServiceLocator
{

    public function __construct($config = array())
    {
        parent::__construct($config);
        $count = $this->registerComponents();
        Yii::info("$count rhoone component(s) registered.", __METHOD__);
    }

    /**
     * Returns the list of the extension definitions or the loaded extension instances.
     * @param boolean $returnDefinitions whether to return extension definitions instead of the loaded extension instances.
     * @return Extension[]
     */
    public function getExtensions($returnDefinitions = true)
    {
        return $this->getExt()->getComponents($returnDefinitions);
    }

    /**
     * 
     * @return integer
     */
    public function registerComponents()
    {
        $count = 0;
        foreach ($this->coreComponents() as $id => $component) {
            try {
                $this->set($id, $component);
            } catch (\Exception $ex) {
                Yii::error("`$id` failed to register: " . $ex->getMessage(), __METHOD__);
            }
            Yii::info("`$id` registered.", __METHOD__);
            $count++;
        }
        return $count;
    }

    /**
     * 
     * @return array
     */
    public function coreComponents()
    {
        return [
            'ext' => ['class' => 'rhoone\base\ExtensionManager'],
            'dic' => ['class' => 'rhoone\base\DictionaryManager'],
            'splitter' => ['class' => 'rhoone\base\KeywordSplitter'],
        ];
    }

    /**
     * 
     * @return ExtensionManager
     */
    public function getExt()
    {
        return $this->get("ext");
    }

    /**
     * 
     * @return DictionaryManager
     */
    public function getDic()
    {
        return $this->get("dic");
    }

    /**
     * 
     * @param string $keyword
     * @return \rhoone\models\Extension[]
     */
    public function match($keyword = "")
    {
        $keyword = new Keyword($keyword);
        $defaults = \rhoone\models\Extension::findAllDefault(true);
        $nonDefaults = [];
        foreach (Yii::$app->rhoone->dic->getSynonyms(null, $keyword->splitted) as $synonym) {
            $nonDefaults[$synonym->extension->guid] = $synonym->extension;
        }
        return array_merge($defaults, $nonDefaults);
        //die();
    }

    /**
     * Search for result to the keywords.
     * @param string $keyword
     */
    public function search($keyword = "")
    {
        Yii::trace("Begin searching...", __METHOD__);
        $matches = $this->match($keyword);
        $result = "";
        foreach ($matches as $extension) {
            $result .= $extension->extension->search($keyword);
        }
        return $result;
    }
}

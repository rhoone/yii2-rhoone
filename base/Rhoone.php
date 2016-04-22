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
use Yii;
use yii\di\ServiceLocator;

/**
 * rhoone component.
 *
 * @property-read ExtensionManager $ext
 * @property-read DictionaryManager $dic
 * @property-read Extension[] $extensions
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
     * Search for result to the keywords.
     * @param string|string[] $keywords
     */
    public function search($keywords = "")
    {
        Yii::trace("Begin searching...", __METHOD__);
        if ((is_string($keywords) && strlen($keywords) == 0) || (is_array($keywords) && empty($keywords)) || !is_numeric($keywords)){
            Yii::warning('Empty keywords!', __METHOD__);
            return null;
        }
        $result = "";
        foreach ($this->extensions as $extension) {
            $result .= $extension->search($keywords);
        }
        return $result;
    }
}

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
use yii\di\ServiceLocator;

/**
 * Description of Rhoone
 *
 * @author vistart <i@vistart.name>
 */
class Rhoone extends ServiceLocator
{

    public function __construct($config = array())
    {
        parent::__construct($config);
        $count = $this->registerComponents();
        Yii::info("$count rhoone components registered.", __METHOD__);
    }

    /**
     * 
     * @return type
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

    public function coreComponents()
    {
        return [
            'extensionManager' => ['class' => 'rhoone\base\ExtensionManager'],
        ];
    }
}

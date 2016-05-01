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

namespace rhoone\widgets\search\result;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * The container of search result.
 *
 * @author vistart <i@vistart.name>
 */
class ContainerWidget extends Widget
{

    /**
     * @var array The config array used for container widget.
     */
    public $containerConfig;

    /**
     * Search Result.
     * @var string|string[] 
     */
    public $results;

    const INIT_CONTAINER_ID = "search-result-container";

    public function init()
    {
        if (!is_array($this->containerConfig)) {
            $this->containerConfig = [];
        }
        if (is_array($this->containerConfig)) {
            $this->containerConfig = ArrayHelper::merge(static::getContainerConfig(), $this->containerConfig);
        }
        if (!isset($this->containerConfig['id'])) {
            throw new InvalidConfigException('The ID of container should be set.');
        }
    }

    /**
     * ID must be set.
     * @return array container config
     */
    public static function getContainerConfig()
    {
        return [
            'id' => self::INIT_CONTAINER_ID,
        ];
    }

    public function run()
    {
        return $this->render('container', ['containerConfig' => $this->containerConfig, 'results' => $this->results]);
    }
}

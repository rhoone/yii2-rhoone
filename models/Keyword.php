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

namespace rhoone\models;

use rhoone\extension\SegmenterInterface;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Model;

/**
 * Description of Keyword
 *
 * @property-read string $raw
 * @property-read array $segmented
 * @property SegmenterInterface $segmenter
 * @author vistart <i@vistart.name>
 */
class Keyword extends Model
{

    /**
     * @var string
     */
    private $_raw;

    /**
     * Keyword is "一站式搜索，内容直达。"
     * [
     *     0 => [
     *         "word" => "一站式",
     *         "count" => 1,
     *     ],
     *     1 => [
     *         "word" => "搜索",
     *         "count" => 1,
     *     ],
     *     2 => [
     *         "word" => "内容",
     *         "count" => 1,
     *     ],
     *     3 => [
     *         "word" => "直达",
     *         "count" => 1,
     *     ],
     * ]
     * @var array
     */
    private $_segmented;
    private $_segmenter;

    public function __construct($config = array())
    {
        if (is_string($config)) {
            $config = ['keyword' => $config, 'segmenter' => Yii::$app->rhoone->segmented];
        }
        parent::__construct($config);
    }
    
    public function __toString()
    {
        return $this->raw;
    }

    public function getSegmenter()
    {
        $segmenter = $this->_segmenter;
        if (is_array($this->_segmenter)) {
            $segmenter = Yii::createObject($segmenter);
        }
        if (!($segmenter instanceof SegmenterInterface && $segmenter instanceof Component)) {
            throw new InvalidConfigException("Segmenter should be extends from `Component` and implement `SegmenterInterface`.");
        }
        return $segmenter;
    }

    /**
     * 
     * @param SegmenterInterface|array $segmenter
     */
    public function setSegmenter($segmenter)
    {
        if (empty($segmenter)) {
            $segmenter = Yii::$app->rhoone->segmenter;
        }
        $this->_segmenter = $segmenter;
    }

    protected function segment($keyword)
    {
        return $this->_segmented = $this->segmenter->segment($keyword);
    }

    public function getRaw()
    {
        return $this->_raw;
    }

    public function getSegmented()
    {
        if (empty($this->raw)) {
            return $this->_segmented = [];
        }
        return $this->segment($this->raw);
    }

    public function getKeyword()
    {
        return [
            'raw' => $this->_raw,
            'segmented' => $this->segmented,
        ];
    }

    public function setKeyword($keyword)
    {
        $this->_raw = $keyword;
    }
}

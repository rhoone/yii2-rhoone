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

use rhoone\extension\SplitterInterface;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Model;

/**
 * Description of Keyword
 *
 * @property-read string $raw
 * @property-read array $splitted
 * @property-read SplitterInterface $splitter
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
    private $_splitted;
    private $_splitter;

    public function __construct($config = array())
    {
        if (is_string($config)) {
            $config = ['keyword' => $config];
        }
        parent::__construct($config);
    }

    public function getSplitter()
    {
        $splitter = $this->_splitter;
        if (is_array($this->_splitter)) {
            $splitter = Yii::createObject($splitter);
        }
        if (!($splitter instanceof SplitterInterface && $splitter instanceof Component)) {
            throw new InvalidConfigException("Splitter should be extends from `Component` and implement `SplitterInterface`.");
        }
        return $splitter;
    }

    /**
     * 
     * @param SplitterInterface|array $splitter
     */
    public function setSplitter($splitter)
    {
        $this->_splitter = $splitter;
    }

    protected function split($keyword)
    {
        return $this->_splitted = $this->splitter->split($keyword);
    }

    public function getRaw()
    {
        return $this->_raw;
    }

    public function getSplitted()
    {
        if (empty($this->_splitted)) {
            return $this->_splitted;
        }
        return $this->split($this->raw);
    }

    public function getKeyword()
    {
        return [
            'raw' => $this->_raw,
            'splitted' => $this->splitted,
        ];
    }

    public function setKeyword($keyword)
    {
        $this->_raw = $keyword;
    }
}

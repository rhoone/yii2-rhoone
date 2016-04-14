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

use rhoone\helpers\DictionaryHelper;
use vistart\Models\models\BaseEntityModel;

/**
 * Description of Extension
 *
 * @property boolean $isEnabled
 * @property-read Headword[] $headwords
 * @author vistart <i@vistart.name>
 */
class Extension extends BaseEntityModel
{

    public $idAttribute = false;
    public $enableIP = 0;

    public function init()
    {
        $this->queryClass = ExtensionQuery::className();
        parent::init();
    }

    public static function tableName()
    {
        return '{{%extension}}';
    }

    public function getExtensionRules()
    {
        return [
            [['name', 'classname', 'description'], 'string', 'max' => 255],
            [['description'], 'default', 'value' => ''],
            [['name', 'classname'], 'required'],
            [['classname'], 'unique'],
            [['enabled', 'monopolized', 'default'], 'boolean', 'trueValue' => 1, 'falseValue' => 0],
            [['enabled', 'monopolized', 'default'], 'default', 'value' => 0],
        ];
    }

    public function rules()
    {
        return array_merge($this->getExtensionRules(), parent::rules());
    }

    public function getIsEnabled()
    {
        return $this->enabled == true;
    }

    public function setIsEnabled($enabled)
    {
        $this->enabled = $enabled == true ? 1 : 0;
    }

    /**
     * Get all extensions enabled.
     * @return static[]
     */
    public static function findAllEnabled()
    {
        return static::find()->enabled()->all();
    }

    /**
     * @inheritdoc
     * Friendly to IDE.
     * @return ExtensionQuery
     */
    public static function find()
    {
        return parent::find();
    }

    /**
     * 
     * @return type
     */
    public function getHeadwords()
    {
        return $this->hasMany(Headword::className(), ['extension_guid' => 'guid'])->inverseOf('extension');
    }

    /**
     * Add headword.
     * @param string|Headword $headword
     * @return false|Headword
     */
    public function setHeadword($headword)
    {
        if (is_string($headword)) {
            return Headword::add($headword, $this);
        }
        if ($headword instanceof Headword) {
            return Headword::add($headword->word, $this);
        }
    }

    /**
     * Add headwords.
     * @param string[]|Headword[] $headwords
     * @return mixed
     */
    public function setHeadwords($headwords)
    {
        $results = [];
        foreach ($headwords as $headword) {
            $results[] = $this->setHeadword($headword);
        }
        return $results;
    }

    /**
     * 
     * @param mixed $dictionary
     * @return boolean
     */
    public function addDictionary($dictionary)
    {
        return DictionaryHelper::add($this, $dictionary);
    }
}

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

namespace rhoone\models;

use rhoone\helpers\DictionaryHelper;
use rhosocial\base\models\models\BaseEntityModel;
use Yii;
use yii\helpers\Json;

/**
 * Description of Extension
 *
 * @property string $name
 * @property string $classname
 * @property string $config_array Configuration Array in JSON.
 * Please DO NOT access it directly, use $config instead.
 * @property integer $enabled
 * @property integer $monopolized
 * @property integer $default
 * @property string $description
 * 
 * @property array $config
 * @property boolean $isEnabled
 * @property boolean $isDefault
 * @property-write string|Headword $headword
 * @property-read Headword[] $headwords
 * @property-write string|Headword[] $headwords
 * @property-read Synonym[] $synonyms
 * @property-write array $dictionary
 * @author vistart <i@vistart.me>
 */
class Extension extends BaseEntityModel
{

    public $idPreassigned = true;
    public $idAttributeLength = 255;
    public $enableIP = 0;

    public function init()
    {
        $this->queryClass = ExtensionQuery::class;
        parent::init();
    }

    public static function tableName()
    {
        return '{{%extension}}';
    }

    public function getExtensionRules()
    {
        return [
            [['id', 'name', 'classname', 'description'], 'string', 'max' => 255],
            [['config_array'], 'string', 'max' => 65535],
            [['description'], 'default', 'value' => ''],
            [['config_array'], 'default', 'value' => Json::encode([])],
            [['id', 'name', 'classname'], 'required'],
            [['id', 'classname'], 'unique'],
            [['enabled', 'monopolized', 'default'], 'boolean', 'trueValue' => 1, 'falseValue' => 0],
            [['enabled', 'monopolized', 'default'], 'default', 'value' => 0],
        ];
    }

    public function rules()
    {
        return array_merge($this->getExtensionRules(), parent::rules());
    }

    public function getConfig()
    {
        try {
            return Json::decode($this->config_array);
        } catch (\Exception $ex) {
            Yii::error($ex->getMessage(), __METHOD__);
            return [];
        }
    }

    public function setConfig($config = null)
    {
        try {
            $this->config_array = Json::encode($config);
        } catch (\Exception $ex) {
            Yii::error($ex->getMessage(), __METHOD__);
            $this->config_array = Json::encode([]);
        }
    }

    public function getIsEnabled()
    {
        return $this->enabled == true;
    }

    public function setIsEnabled($enabled)
    {
        $this->enabled = $enabled == true ? 1 : 0;
    }

    public function getIsDefault()
    {
        return $this->default == true;
    }

    public function setIsDefault($default)
    {
        $this->default = $default == true ? 1 : 0;
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
     * 
     * @param boolean|fnull $enabled
     * @return static[]
     */
    public static function findAllDefault($enabled = null)
    {
        if (is_bool($enabled)) {
            return static::find()->isDefault()->enabled($enabled)->all();
        }
        return static::find()->isDefault()->all();
    }

    /**
     * 
     * @param boolean|null $enabled
     * @return static[]
     */
    public static function findAllNonDefault($enabled = null)
    {
        if (is_bool($enabled)) {
            return static::find()->isDefault(false)->enabled($enabled)->all();
        }
        return static::find()->isDefault(false)->all();
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
     * @return HeadwordQuery
     */
    public function getHeadwords()
    {
        return $this->hasMany(Headword::class, ['extension_guid' => 'guid'])->inverseOf('extension');
    }

    /**
     * 
     * @return SynonymQuery
     */
    public function getSynonyms()
    {
        return $this->hasMany(Synonym::class, ['headword_guid' => 'guid'])->via('headwords');
    }

    /**
     * Add headword.
     * @param string|Headword $headword
     * `string`: Headword string.
     * `Headword`: Headword model.
     * @return false|Headword
     */
    public function setHeadword($headword, $addSynonyms = false)
    {
        if (is_string($headword)) {
            return Headword::add($headword, $this, $addSynonyms);
        }
        if ($headword instanceof Headword) {
            return Headword::add($headword->word, $this, $addSynonyms);
        }
    }

    /**
     * Remove headword.
     * @param string|Headword $word
     */
    public function removeHeadword($word)
    {
        if (is_string($word)) {
            $headword = $this->getHeadwords()->word($word)->one();
            return $headword && $headword->delete() == 1;
        }
        if ($word instanceof Headword && $word->extension == $this) {
            return $word->delete() == 1;
        }
    }

    /**
     * 
     * @return int
     */
    public function removeAllHeadwords()
    {
        return Headword::deleteAll(['extension_guid' => $this->guid]);
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
    public function setDictionary($dictionary)
    {
        return DictionaryHelper::add($this, $dictionary);
    }

    /**
     * 
     * @param mixed $dictionary
     * @return boolean
     */
    public function addDictionary($dictionary)
    {
        return $this->setDictionary($dictionary);
    }

    public function getExtension()
    {
        $class = $this->classname;
        return new $class($this->config);
    }
}

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

use vistart\Models\models\BaseEntityModel;
use vistart\helpers\Number;
use yii\base\InvalidParamException;
use Yii;

/**
 * Description of Headword
 * 
 * @property string $extension_guid
 * @property string $word
 *
 * @property-read Extension $extension
 * @property-write string|Extension $extension
 * @property-read Synonym $synonyms
 * @property-write string|Synonym $synonyms
 * @author vistart <i@vistart.name>
 */
class Headword extends BaseEntityModel
{

    public $idAttribute = false;
    public $enableIP = 0;

    public function init()
    {
        $this->queryClass = HeadwordQuery::className();
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'onInsertHeadword']);
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%headword}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['word', 'extension_guid'], 'required'],
            [['word'], 'string', 'max' => 512],
            [['extension_guid'], 'string', 'max' => 36],
            [['word', 'extension_guid'], 'unique', 'targetAttribute' => ['word', 'extension_guid'], 'message' => 'The combination of Word and Extension Guid has already been taken.'],
            [['extension_guid'], 'exist', 'skipOnError' => true, 'targetClass' => Extension::className(), 'targetAttribute' => ['extension_guid' => 'guid']],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'guid' => Yii::t('app', 'Guid'),
            'word' => Yii::t('app', 'Word'),
            'extension_guid' => Yii::t('app', 'Extension Guid'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * Get extension query.
     * @return ExtensionQuery
     */
    public function getExtension()
    {
        return $this->hasOne(Extension::className(), ['guid' => 'extension_guid']);
    }

    /**
     * Set extension.
     * @param Extension|string $extension
     */
    public function setExtension($extension)
    {
        if (is_string($extension) && preg_match(Number::GUID_REGEX, $extension)) {
            return $this->extension_guid = $extension;
        }
        if ($extension instanceof Extension) {
            return $this->extension_guid = $extension->guid;
        }
        return false;
    }

    /**
     * Get synonyms query.
     * @return SynonymQuery
     */
    public function getSynonyms()
    {
        return $this->hasMany(Synonym::className(), ['headword_guid' => 'guid'])->inverseOf('headword');
    }

    /**
     * Add a headword.
     * @param string $word
     * @param Extension $extension
     * @return true|\static
     * @throws InvalidParamException
     */
    public static function add($word, $extension)
    {
        $headword = Headword::find()->where(['word' => $word, 'extension_guid' => $extension->guid])->one();
        if ($headword) {
            throw new InvalidParamException('The word: `' . $word . '` has existed.');
        }
        $headword = new Headword(['word' => $word, 'extension' => $extension]);
        $transaction = $headword->getDb()->beginTransaction();
        try {
            if (!$headword->save()) {
                if (YII_ENV !== YII_ENV_PROD) {
                    var_dump($headword->errors);
                }
                throw new InvalidParamException("Failed to add headword.");
            }
            $transaction->commit();
        } catch (\Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }
        return $headword;
    }

    /**
     * 
     * @param string $word
     * @param Extension $extension
     * @return boolean
     */
    public static function remove($word, $extension)
    {
        $headword = Headword::find()->where(['word' => $word, 'extension_guid' => $extension->guid])->one();
        if (!$headword) {
            Yii::warning($word . ' does not exist.', __METHOD__);
            return false;
        }
        return $headword->delete() == 1;
    }

    /**
     * Add synonyms.
     * @param string|string[]|Synonym|Synonym[] $synonyms
     * `string`: Synonym string.
     * `string[]`: Synonym string array.
     * `Synonym`: Synonym model.
     * `Synonym[]`: Synonym models.
     * String if it is a synonym string, or Synonym instance.
     * @return boolean
     * @throws InvalidParamException
     */
    public function setSynonyms($synonyms)
    {
        if (is_string($synonyms)) {
            if (Synonym::find()->where(['word' => $synonyms, 'headword_guid' => $this->guid])->exists()) {
                throw new InvalidParamException('The synonyms: `' . $synonyms . '` has existed.');
            }
            $model = new Synonym(['word' => $synonyms, 'headword' => $this]);
            return $model->save();
        }
        if ($synonyms instanceof Synonym) {
            if (Synonym::find()->where(['word' => $synonyms->word, 'headword_guid' => $this->guid])->exists()) {
                throw new InvalidParamException('The synonyms: `' . $synonyms->word . '` has existed.');
            }
            $synonyms->headword = $this;
            return $synonyms->save();
        }
        if (is_array($synonyms)) {
            foreach ($synonyms as $syn) {
                if (!$this->setSynonyms($syn)) {
                    Yii::error('Synonyms failed to add.', __METHOD__);
                }
            }
        }
        return true;
    }

    /**
     * Remove synonyms.
     * @param string|string[]|Synonym|Synonym[] $synonyms
     * @return boolean
     */
    public function removeSynonyms($synonyms)
    {
        if (is_string($synonyms)) {
            if ($synonyms === $this->word) {
                throw new InvalidParamException("`$synonyms` is same as headword, it cannot be deleted.");
            }
            $model = Synonym::find()->where(['word' => $synonyms, 'headword_guid' => $this->guid])->one();
            if (!$model) {
                Yii::warning($synonyms . ' does not exist.', __METHOD__);
                return false;
            }
            return $model->delete() == 1;
        }
        if ($synonyms instanceof Synonym && $synonyms->headword == $this) {
            if ($synonyms->word === $this->word) {
                throw new InvalidParamException("Synonyms `" . $synonyms->word . "` is same as headword, it cannot be deleted.");
            }
            return $synonyms->delete() == 1;
        }
        return false;
    }

    /**
     * Remove all synonyms.
     * @return integer the number of synonyms deleted.
     */
    public function removeAllSynonyms()
    {
        return Synonym::deleteAll(['headword_guid' => $this->guid]);
    }

    /**
     * @inheritdoc
     * Friendly to IDE.
     * @return HeadwordQuery
     */
    public static function find()
    {
        return parent::find();
    }

    /**
     * 
     * @param \yii\db\AfterSaveEvent $event
     */
    public function onInsertHeadword($event)
    {
        $sender = $event->sender;
        /* @var $sender static */
        return $sender->setSynonyms($sender->word);
    }
}

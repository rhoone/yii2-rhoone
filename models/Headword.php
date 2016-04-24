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
 * @property-read Synonyms $synonyms
 * @property-write string|Synonyms $synonyms
 * @author vistart <i@vistart.name>
 */
class Headword extends BaseEntityModel
{

    public $idAttribute = false;
    public $enableIP = 0;

    public function init()
    {
        $this->queryClass = HeadwordQuery::className();
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
            [['word'], 'string', 'max' => 255],
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
     * @return SynonymsQuery
     */
    public function getSynonyms()
    {
        return $this->hasMany(Synonyms::className(), ['headword_guid' => 'guid'])->inverseOf('headword');
    }

    /**
     * Add a headword.
     * @param string $word
     * @param Extension $extension
     * @param boolean $addSynonyms
     * @return true|\static
     * @throws InvalidParamException
     */
    public static function add($word, $extension, $addSynonyms = false)
    {
        $headword = Headword::find()->where(['word' => $word, 'extension_guid' => $extension->guid])->one();
        if ($headword) {
            throw new InvalidParamException('The word: `' . $word . '` has existed.');
        }
        $headword = new Headword(['word' => $word, 'extension' => $extension]);
        $transaction = $headword->getDb()->beginTransaction();
        try {
            if (!$headword->save()) {
                throw new InvalidParamException("Failed to add headword.");
            }
            if ($addSynonyms && !$headword->setSynonyms($word)) {
                throw new InvalidParamException("Failed to add synonyms.");
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
     * @param string|string[]|Synonyms|Synonyms[] $synonyms
     * `string`: Synonyms string.
     * `string[]`: Synonyms string array.
     * `Synonyms`: Synonyms model.
     * `Synonyms[]`: Synonyms models.
     * String if it is a synonyms string, or Synonyms instance.
     * @return boolean
     * @throws InvalidParamException
     */
    public function setSynonyms($synonyms)
    {
        if (is_string($synonyms)) {
            if (Synonyms::find()->where(['word' => $synonyms, 'headword_guid' => $this->guid])->exists()) {
                throw new InvalidParamException('The synonyms: `' . $synonyms . '` has existed.');
            }
            $model = new Synonyms(['word' => $synonyms, 'headword' => $this]);
            return $model->save();
        }
        if ($synonyms instanceof Synonyms) {
            if (Synonyms::find()->where(['word' => $synonyms->word, 'headword_guid' => $this->guid])->exists()) {
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
     * @param string|string[]|Synonyms|Synonyms[] $synonyms
     * @return boolean
     */
    public function removeSynonyms($synonyms)
    {
        if (is_string($synonyms)) {
            $model = Synonyms::find()->where(['word' => $synonyms, 'headword_guid' => $this->guid])->one();
            if (!$model) {
                Yii::warning($synonyms . ' does not exist.', __METHOD__);
                return false;
            }
            return $model->delete() == 1;
        }
        if ($synonyms instanceof Synonyms && $synonyms->headword == $this) {
            return $synonyms->delete() == 1;
        }
    }

    /**
     * Remove all synonyms.
     * @return integer the number of synonyms deleted.
     */
    public function removeAllSynonyms()
    {
        return Synonyms::deleteAll(['headword_guid' => $this->guid]);
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
}

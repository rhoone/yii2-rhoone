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
use Yii;

/**
 * Description of Headword
 * 
 * @property string $extension_guid
 * @property string $word
 *
 * @property-read Extension $extension
 * @property-read Synonyms $synonyms
 * @property-write string|Synonyms $synonyms
 * @author vistart <i@vistart.name>
 */
class Headword extends BaseEntityModel
{

    public $idAttribute = false;
    public $enableIP = 0;

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
     * 
     * @return ExtensionQuery
     */
    public function getExtension()
    {
        return $this->hasOne(Extension::className(), ['guid' => 'extension_guid']);
    }

    /**
     * 
     * @param Extension $extension
     */
    public function setExtension($extension)
    {
        return $this->extension_guid = $extension->guid;
    }

    /**
     * 
     * @return type
     */
    public function getSynonyms()
    {
        return $this->hasMany(Synonyms::className(), ['headword_guid' => 'guid'])->inverseOf('headword');
    }

    /**
     * Add a headword.
     * @param string $word
     * @param Extension $extension
     * @return false|\static
     */
    public static function add($word, $extension)
    {
        $headword = Headword::find()->where(['word' => $word, 'extension_guid' => $extension->guid])->one();
        if ($headword) {
            Yii::warning($word . ' exists.', __METHOD__);
            return false;
        }
        $headword = new Headword(['word' => $word, 'extension' => $extension]);
        if ($headword->save()) {
            return $headword;
        }
        return false;
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
     */
    public function setSynonyms($synonyms)
    {
        if (is_string($synonyms)) {
            $model = new Synonyms(['word' => $synonyms, 'headword' => $this]);
            if (!$model->save()) {
                if (YII_ENV == YII_ENV_DEV || YII_ENV == YII_ENV_TEST) {
                    print_r($model->errors);
                }
                return false;
            }
            return true;
        }
        if ($synonyms instanceof Synonyms) {
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
        if ($synonyms instanceof Synonyms) {
            return $synonyms->delete() == 1;
        }
    }

    /**
     * 
     * @return int
     */
    public function removeAllSynonyms()
    {
        return Synonyms::deleteAll(['headword_guid' => $this->guid]);
    }
}

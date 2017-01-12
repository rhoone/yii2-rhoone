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

use rhosocial\helpers\Number;
use rhosocial\base\models\models\BaseEntityModel;
use Yii;

/**
 * Description of Synonym
 * 
 * @property string $headword_guid
 * @property string $word
 * 
 * @property Headword $headword
 * @property-read Extension $extension
 *
 * @author vistart <i@vistart.me>
 */
class Synonym extends BaseEntityModel
{

    public $idAttribute = false;
    public $enableIP = 0;

    public static function tableName()
    {
        return '{{%synonym}}';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['word', 'headword_guid'], 'required'],
            [['headword_guid'], 'string', 'max' => 36],
            [['word'], 'string', 'max' => 512],
            [['word', 'headword_guid'], 'unique', 'targetAttribute' => ['word', 'headword_guid'], 'message' => 'The combination of Word and Headword Guid has already been taken.'],
            [['headword_guid'], 'exist', 'skipOnError' => true, 'targetClass' => Headword::class, 'targetAttribute' => ['headword_guid' => 'guid']],
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
            'headword_guid' => Yii::t('app', 'Headword Guid'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeadword()
    {
        return $this->hasOne(Headword::class, ['guid' => 'headword_guid']);
    }

    /**
     * 
     * @param Headword $headword
     */
    public function setHeadword($headword)
    {
        return $this->headword_guid = $headword->guid;
    }

    /**
     * @return ExtensionQuery
     */
    public function getExtension()
    {
        return $this->hasOne(Extension::class, ['guid' => 'extension_guid'])->via('headword');
    }

    public function init()
    {
        $this->queryClass = SynonymQuery::class;
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'onDeleteSynonym']);
        parent::init();
    }

    /**
     * @inheritdoc
     * Friendly to IDE.
     * @return SynonymQuery
     */
    public static function find()
    {
        return parent::find();
    }

    /**
     * 
     * @param \yii\base\ModelEvent $event
     */
    public function onDeleteSynonym($event)
    {
        $sender = $event->sender;
        /* @var $sender static */
        $headword = $sender->headword;
        if ($sender->word == $headword->word) {
            $sender->addError('word', 'The synonym cannot be deleted.');
            $event->isValid = false;
        }
    }

    /**
     * 
     * @param string|static $synonym
     * @return boolean
     */
    public function isSynonymous($synonym)
    {
        if (is_string($synonym)) {
            if (preg_match(Number::GUID_REGEX, $synonym)) {
                $synonym = static::findOne($synonym);
            } else {
                $synonym = static::find()->word($synonym)->one();
            }
        }
        return $synonym instanceof static && $synonym->headword_guid == $this->headword_guid;
    }
}

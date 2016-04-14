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

/**
 * Description of Synonmys
 *
 * @author vistart <i@vistart.name>
 */
class Synonmys extends BaseEntityModel
{

    public $idAttribute = false;
    public $enableIP = 0;

    public static function tableName()
    {
        return '{{%synonmys}}';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['word', 'headword_guid'], 'required'],
            [['headword_guid'], 'string', 'max' => 36],
            [['word'], 'string', 'max' => 255],
            [['word', 'headword_guid'], 'unique', 'targetAttribute' => ['word', 'headword_guid'], 'message' => 'The combination of Word and Headword Guid has already been taken.'],
            [['headword_guid'], 'exist', 'skipOnError' => true, 'targetClass' => Headword::className(), 'targetAttribute' => ['headword_guid' => 'guid']],
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
        return $this->hasOne(Headword::className(), ['guid' => 'headword_guid']);
    }
}

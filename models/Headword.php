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
 * Description of Headword
 *
 * @property-read Extension $extension
 * @property-read Synonmys $synonmys
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
     * @return type
     */
    public function getSynonmys()
    {
        return $this->hasMany(Synonmys::className(), ['headword_guid' => 'guid'])->inverseOf('headword');
    }
}

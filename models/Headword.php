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
 * @property-read Synonmys $synonmys
 * @property-write string|Synonmys $synonmys
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
    public function getSynonmys()
    {
        return $this->hasMany(Synonmys::className(), ['headword_guid' => 'guid'])->inverseOf('headword');
    }

    /**
     * 
     * @param string $word
     * @param Extension $extension
     * @return boolean|\rhoone\models\Headword
     */
    public static function add($word, $extension)
    {
        $headword = Headword::find()->where(['word' => $word, 'extension_guid' => $extension->guid])->one();
        if (!$headword) {
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
     * Add synonmys.
     * @param string|string[]|Synonmys|Synonmys[] $synonmys
     */
    public function setSynonmys($synonmys)
    {
        if (is_string($synonmys)) {
            $model = new Synonmys(['word' => $synonmys, 'headword' => $this]);
            return $model->save();
        }
        if ($synonmys instanceof Synonmys) {
            $synonmys->headword = $this;
            return $synonmys->save();
        }
        if (is_array($synonmys)) {
            foreach ($synonmys as $syn) {
                if (!$this->setSynonmys($syn)) {
                    Yii::error('Synonmys failed to add.', __METHOD__);
                }
            }
        }
        return true;
    }

    /**
     * Remove synonmys.
     * @param string|string[]|Synonmys|Synonmys[] $synonmys
     * @return boolean
     */
    public function removeSynonmys($synonmys)
    {
        if (is_string($synonmys)) {
            $model = Synonmys::find()->where(['word' => $synonmys, 'headword_guid' => $this->guid])->one();
            if (!$model) {
                Yii::warning($synonmys . ' does not exist.', __METHOD__);
                return false;
            }
            return $model->delete() == 1;
        }
        if ($synonmys instanceof Synonmys) {
            return $synonmys->delete() == 1;
        }
    }

    public function removeAllSynonmys()
    {
        return Synonmys::deleteAll(['headword_guid' => $this->guid]);
    }
}

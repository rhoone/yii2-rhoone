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

use rhosocial\base\models\models\BaseEntityModel;
use Yii;

/**
 * This is the model class for table "{{%server}}".
 *
 * @property string $guid
 * @property string $id
 * @property string $name
 * @property string $endpoint
 * @property string $create_time
 * @property string $update_time
 *
 * @author vistart <i@vistart.me>
 */
class Server extends BaseEntityModel
{

    public $idPreassigned = true;
    public $idAttributeLength = 255;
    public $enableIP = 0;

    public function init()
    {
        $this->queryClass = ServerQuery::class;
        parent::init();
    }

    /**
     * @inheritdoc 
     */
    public static function tableName()
    {
        return '{{%server}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'endpoint'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['endpoint'], 'string', 'max' => 1024],
            [['endpoint'], 'unique'],
        ]);
    }

    public function attributeLabels()
    {
        return [
            'guid' => Yii::t('app', 'Server GUID'),
            'id' => Yii::t('app', 'Server ID'),
            'name' => Yii::t('app', 'Server Name'),
            'endpoint' => Yii::t('app', 'Endpoint'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * @inheritdoc
     * Friendly to IDE.
     * @return ServerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return parent::find();
    }
}

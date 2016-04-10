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
 * Description of Extension
 *
 * @author vistart <i@vistart.name>
 */
class Extension extends BaseEntityModel
{

    public $idAttribute = false;
    public $enableIP = 0;
    
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
            [['enabled', 'monopolized', 'default'], 'boolean', 'trueValue' => 1, 'falseValue' => 0],
            [['enabled', 'monopolized', 'default'], 'default', 'value' => 0],
        ];
    }

    public function rules()
    {
        return array_merge($this->getExtensionRules(), parent::rules());
    }
}

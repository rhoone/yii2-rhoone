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

use rhosocial\base\models\models\BaseEntityModel;

/**
 * Description of Segmenter
 *
 * @author vistart <i@vistart.name>
 */
class Segmenter extends BaseEntityModel
{
    public static function tableName()
    {
        return '{{%segmenter}}';
    }
}

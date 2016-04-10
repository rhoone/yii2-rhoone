<?php

/* *
 *  _   __ __ _____ _____ ___  ____  _____
 * | | / // // ___//_  _//   ||  __||_   _|
 * | |/ // /(__  )  / / / /| || |     | |
 * |___//_//____/  /_/ /_/ |_||_|     |_|
 * @link https://vistart.name/
 * @copyright Copyright (c) 2016 vistart
 * @license https://vistart.name/license/
 */

namespace rhoone\models;

use yii\base\Model;

/**
 * Description of SearchForm
 *
 * @author vistart <i@vistart.name>
 */
class SearchForm extends Model
{

    public $keywords = '';

    public function rules()
    {
        return [
            ['keywords', 'string', 'max' => 255],
        ];
    }
}

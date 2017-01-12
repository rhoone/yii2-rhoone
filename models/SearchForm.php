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

use yii\base\Model;

/**
 * Description of SearchForm
 *
 * @author vistart <i@vistart.me>
 */
class SearchForm extends Model
{

    /**
     * @var string Store the keyword.
     */
    public $keywords = '';

    public function rules()
    {
        return [
            ['keywords', 'required'],
            ['keywords', 'trim'],
            ['keywords', 'string', 'max' => 255],
        ];
    }
}

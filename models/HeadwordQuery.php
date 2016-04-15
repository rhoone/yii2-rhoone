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

use vistart\Models\queries\BaseEntityQuery;

/**
 * Description of HeadwordQuery
 *
 * @author vistart <i@vistart.name>
 */
class HeadwordQuery extends BaseEntityQuery
{

    /**
     * 
     * @param string $word
     * @return \static
     */
    public function word($word)
    {
        if (!is_string($word)) {
            return $this;
        }
        return $this->andWhere(['word' => $word]);
    }
}

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
 * Description of SynonymsQuery
 *
 * @author vistart <i@vistart.name>
 */
class SynonymsQuery extends BaseEntityQuery
{

    public function extension($extension)
    {
        if ($extension instanceof Extension) {
            
        }
    }

    /**
     * Attach headword.
     * @param string|Headword $headword
     * @return \static
     */
    public function headword($headword)
    {
        if ($headword instanceof Headword) {
            return $this->andWhere(['headword_guid' => $headword->guid]);
        }
        if (is_string($headword)) {
            $headword = Headword::find()->where(['word' => $headword])->one();
            if (!$headword) {
                return $this;
            }
            return $this->andWhere(['headword_guid' => $headword->guid]);
        }
    }

    /**
     * 
     * @param string}string[] $word
     * @return \static
     */
    public function word($word)
    {
        return $this->andWhere(['word' => $word]);
    }
}

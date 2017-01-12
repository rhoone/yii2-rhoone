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

use rhosocial\helpers\Number;
use rhosocial\base\models\queries\BaseEntityQuery;
use Yii;

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
    
    public function extension($extension)
    {
        $extension = (array) $extension;
        $guids = [];
        foreach ($extension as $k => $e) {
            if (is_string($e) && !preg_match(Number::GUID_REGEX, $e)) {
                $e = Yii::$app->rhoone->ext->getModel($e);
            }
            if (!is_string($e) || !($e instanceof Extension)) {
                unset($extension[$k]);
            }
            $guids[] = $e->guid;
        }
        return $this->andWhere(['extension_guid' => $guids]);
    }
}

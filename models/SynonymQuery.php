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

use rhosocial\helpers\Number;
use rhosocial\base\models\queries\BaseEntityQuery;
use Yii;

/**
 * Description of SynonymQuery
 *
 * @author vistart <i@vistart.me>
 */
class SynonymQuery extends BaseEntityQuery
{

    /**
     * 
     * @param string[]|\rhoome\models\Extension[]|\rhoone\extension\Extension[] $extension
     * @return type
     */
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
        return $this->leftJoin(Headword::tableName(), '`headword_guid` = ' . Headword::tableName() . '.`guid`')
                ->leftJoin(Extension::tableName(), Headword::tableName() . '.`extension_guid` = ' . Extension::tableName() . '.`guid`')
                ->andWhere(['extension_guid' => $guids]);
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
    public function word($word, $like = false)
    {
        if (is_string($word)) {
            return $this->likeCondition($word, Synonym::tableName() . '.word', $like);
        }
        return $this->andWhere([Synonym::tableName() . '.word' => $word]);
    }
}

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
 * Query for Extension
 *
 * @author vistart <i@vistart.name>
 */
class ExtensionQuery extends BaseEntityQuery
{

    /**
     * Attach enabled condition.
     * @param mixed $enabled
     * @return \static
     */
    public function enabled($enabled = true)
    {
        return $this->andWhere(['enabled' => $enabled == true ? 1 : 0]);
    }
}

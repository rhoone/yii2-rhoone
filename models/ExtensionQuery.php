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

use rhosocial\base\models\queries\BaseEntityQuery;

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
        if (is_bool($enabled)) {
            return $this->andWhere(['enabled' => $enabled == true ? 1 : 0]);
        }
        return $this;
    }

    public function isDefault($default = true)
    {
        if (is_bool($default)) {
            return $this->andWhere(['default' => $default == true ? 1 : 0]);
        }
        return $this;
    }

    public function monopolized($monopolized = true)
    {
        if (is_bool($monopolized)) {
            return $this->andWhere(['monopolized' => $monopolized == true ? 1 : 0]);
        }
        return $this;
    }
}

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

namespace rhoone\base;

/**
 * Description of InvalidExtensionException
 *
 * @author vistart <i@vistart.name>
 */
class InvalidExtensionException extends \Exception
{

    public function getName()
    {
        return "Invalid Extension.";
    }
}
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

namespace rhoone\extension;

use yii\base\NotSupportedException;

/**
 * Description of Server
 *
 * @author vistart <i@vistart.name>
 */
abstract class Server extends Extension
{

    /**
     * Server name.
     * @throws NotSupportedException
     */
    public static function name()
    {
        throw new NotSupportedException('The server\'s name has not been specified.');
    }

    public static function getHosts()
    {
        throw new NotSupportedException('The server\'s secure hosts have not been specified.');
    }

    public static function getSearchEndpoints()
    {
        throw new NotSupportedException('The server\'s search endpoints have not been specified.');
    }

    public static function getAdminEndpoint()
    {
        throw new NotSupportedException('The server\'s administration endpoint has not been specfied.');
    }
}

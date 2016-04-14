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

    /**
     * Trusted hosts (hostname or IP address).
     * @throws NotSupportedException
     */
    public static function getHosts()
    {
        throw new NotSupportedException('The server\'s secure hosts have not been specified.');
    }

    /**
     * Trusted search endpoints.
     * @throws NotSupportedException
     */
    public static function getSearchEndpoints()
    {
        throw new NotSupportedException('The server\'s search endpoints have not been specified.');
    }

    /**
     * Trusted administration endpoint.
     * @throws NotSupportedException
     */
    public static function getAdminEndpoint()
    {
        throw new NotSupportedException('The server\'s administration endpoint has not been specfied.');
    }

    const INFO_KEY_NAME = 'name';
    const INFO_KEY_HOSTS = 'hosts';
    const INFO_KEY_SEARCH_ENDPOINTS = 'search_endpoints';
    const INFO_KEY_ADMIN_ENDPOINT = 'admin-endpoint';

    /**
     * 
     * @return array
     */
    public static function getServerInfo()
    {
        return [
            self::INFO_KEY_NAME => static::name(),
            self::INFO_KEY_HOSTS => static::getHosts(),
            self::INFO_KEY_SEARCH_ENDPOINTS => static::getSearchEndpoints(),
            self::INFO_KEY_ADMIN_ENDPOINT => static::getAdminEndpoint(),
        ];
    }
}

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

namespace rhoone\controllers;

use yii\web\Controller;
use Yii;
/**
 * Description of SubordinateController
 *
 * @author vistart <i@vistart.me>
 */
class SubordinateController extends Controller
{
    public function actionIndex()
    {
        return $this->goHome();
    }
    
    public function actionRegister()
    {
        return $this->goHome();
    }
    
    public function actionRegisterSubordinate()
    {
        return $this->goHome();
    }
    
    public function actionDeregisterSubordinate()
    {
        return $this->goHome();
    }
}

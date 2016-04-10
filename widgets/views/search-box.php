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
?>
<div class="panel">
    <div class="panel-heading"><strong>搜索</strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form method="GET" action="<?= \yii\helpers\Url::toRoute('/search') ?>">
                    <div class="form-group form-group-search">
                        <input type="text" placeholder="Search for all" name="keywords" class="form-control form-search" id="search-input-field">
                        <button class="btn btn-default btn-sm form-button-search" type="submit">搜索</button>
                    </div>
                    <br>
                </form>        
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>
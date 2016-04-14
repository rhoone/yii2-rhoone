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
/* @var $results string[] */
?>
<?php if (!empty($results)) : ?>
    <div class="row">
        <div class="col-md-2">

        </div>
        <div class="col-md-10">
            <div class="searchResults">
                <?php foreach ($results as $key => $result): ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?= $key ?>
                        </div>
                        <hr/>
                        <div class="panel-body">
                            <?= $result ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
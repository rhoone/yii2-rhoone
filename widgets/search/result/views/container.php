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
/* @var $containerConfig array */
/* @var $results mixed */
?>
<div
<?php foreach ($containerConfig as $key => $value): ?>
    <?= " $key=\"$value\"" ?>
<?php endforeach; ?>
    class="search-result-container">
        <?php if (is_string($results) || is_numeric($results)): ?>
            <?php $results = (array) $results; ?>
        <?php endif; ?>
        <?php if (is_array($results)): ?>
            <?php foreach ($results as $r): ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $r ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
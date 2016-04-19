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
/* @var $result mixed */
?>
<div
<?php foreach ($containerConfig as $key => $value): ?>
    <?= " $key=\"$value\"" ?>
<?php endforeach; ?>
    class="search-result-container">
    <?php if (is_array($result)): ?>
        <?php foreach ($result as $r): ?>
            <?= $r ?>
        <?php endforeach; ?>
    <?php elseif (is_string($result) || is_numeric($result)) : ?>
        <?= $result ?>
    <?php endif; ?>
</div>
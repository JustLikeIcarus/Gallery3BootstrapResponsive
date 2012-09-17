<?php defined("SYSPATH") or die("No direct script access.") ?>
<? if ($anchor): ?>
<a name="<?= $anchor ?>"></a>
<? endif ?>
<div class="clearfix">
    <h3 id="<?= $css_id ?>" class="nav-header"><?= $title ?></h3>
    <div><?= $content ?></div>
</div>
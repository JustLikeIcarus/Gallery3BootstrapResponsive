<?php defined("SYSPATH") or die("No direct script access.") ?>
<ul class="nav nav-list">
<? if (module::get_var("embedlinks", "HTMLCode")) { ?>
<li>
<a href="<?= url::site("embedlinks/showhtml/{$item->id}") ?>" title="<?= t("HTML Links") ?>"
  class="g-dialog-link">
  <i class="icon-info-sign icon-white"></i>
  <?= t("Show HTML Code") ?>
</a>
</li>
<? } ?>

<? if (module::get_var("embedlinks", "BBCode")) { ?>
<li>
<a href="<?= url::site("embedlinks/showbbcode/{$item->id}") ?>" title="<?= t("BBCode Links") ?>"
  class="g-dialog-link">
  <i class="icon-info-sign icon-white"></i>
  <?= t("Show BBCode") ?>
</a>
</li>
<? } ?>

<? if (module::get_var("embedlinks", "FullURL")) { ?>
<li>
<a href="<?= url::site("embedlinks/showfullurl/{$item->id}") ?>" title="<?= t("URLs") ?>"
  class="g-dialog-link">
  <i class="icon-info-sign icon-white"></i>
  <?= t("Show URLs") ?>
</a>
</li>
<? } ?>
</ul>
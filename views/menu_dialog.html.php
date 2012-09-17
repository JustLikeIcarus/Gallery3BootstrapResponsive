<?php defined("SYSPATH") or die("No direct script access.") ?>
<li>
  <a <?= $menu->css_id ? "id='{$menu->css_id}'" : "" ?>
     class="g-dialog-link <?= $menu->css_class ?>"
     href="<?= $menu->url ?>"
     data-toggle="modal"
     data-remote="true"
     data-target="#g-modal"
     title="<?= $menu->label->for_html_attr() ?>">
    <?= $menu->label->for_html() ?>
  </a>
</li>

<?php defined("SYSPATH") or die("No direct script access.") ?>
<ul class="nav nav-list">
<? foreach($feeds as $url => $title): ?>
  <li>        
    <a href="<?= rss::url($url) ?>">
      <i class="icon-rss"></i> <?= html::purify($title) ?>
    </a>  
  </li>
<? endforeach ?>
</ul>

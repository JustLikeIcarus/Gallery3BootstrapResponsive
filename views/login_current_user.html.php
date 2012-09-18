<?php defined("SYSPATH") or die("No direct script access.") ?>
  <? $name = $menu->label->for_html() ?>
  <? $hover_text = t("Your profile")->for_html_attr() ?>
  <?= t("%name", array("name" => html::mark_clean(
        "<a href='$menu->url' class='btn btn-success' title='$hover_text' id='$menu->id'><i class='icon-user icon-white'></i> {$name}</a>"))) ?>

<?php defined("SYSPATH") or die("No direct script access.") ?>
<? // @todo Set hover on AlbumGrid list items for guest users ?>
<div class="page-header">
  <?= $theme->album_top() ?>
  <h1><?= html::purify($item->title) ?></h1>
</div>                   
<? if ($theme->item() && !empty($parents)): ?>
<ul class="breadcrumb">
    <? $i = 0 ?>
    <? foreach ($parents as $parent): ?>
        <li<? if ($i == 0) print " class=\"g-first\"" ?>>
            <? // Adding ?show=<id> causes Gallery3 to display the page
            // containing that photo.  For now, we just do it for
            // the immediate parent so that when you go back up a
            // level you're on the right page. ?>
            <a href="<?= $parent->url($parent->id == $theme->item()->parent_id ?
                                    "show={$theme->item()->id}" : null) ?>">
            <? // limit the title length to something reasonable (defaults to 15) ?>
            <?= html::purify(text::limit_chars($parent->title,
                module::get_var("gallery", "visible_title_length"))) ?>                    
            </a>
            <span class="divider">/</span>
        </li>
        <? $i++ ?>
        <? endforeach ?>
        <li class="active<? if ($i == 0) print " g-first" ?>">
            <?= html::purify(text::limit_chars($theme->item()->title,
                    module::get_var("gallery", "visible_title_length"))) ?>
        </li>
</ul>
<? endif ?>
<div class="g-description"><?= nl2br(html::purify($item->description)) ?></div>
<ul id="g-album-grid" class="thumbnails row-fluid clearfix">
<? if (count($children)): ?>
  <? foreach ($children as $i => $child): ?>
    <? $item_class = "g-photo"; ?>
    <? if ($child->is_album()): ?>
      <? $item_class = "g-album"; ?>
    <? endif ?>
  <li id="g-item-id-<?= $child->id ?>" class="g-item span4 clearfix <?= $item_class ?>">
    <div class="thumbnail">        
        <div class="constraint">
        <a href="<?= $child->url() ?>">
            <? if ($child->has_thumb()): ?>
                <?= $child->thumb_img(array("class" => "g-thumbnail")) ?>
            <? endif ?>
        </a>
        </div>
        <?= $theme->thumb_top($child) ?>
        <?= $theme->thumb_bottom($child) ?>                 
        <?= $theme->context_menu($child, "#g-item-id-{$child->id} .g-thumbnail") ?>
        <div class="caption">
        <h3><span class="<?= $item_class ?>"></span>
            <a href="<?= $child->url() ?>"><?= html::purify($child->title) ?></a></h3>
            <ul class="g-metadata">
                <?= $theme->thumb_info($child) ?>
            </ul>
        </div>
    </div>
  </li>
  <? endforeach ?>
<? else: ?>
  <? if ($user->admin || access::can("add", $item)): ?>
  <? $addurl = url::site("uploader/index/$item->id") ?>
  <li class="span12"><?= t("There aren't any photos here yet! <a %attrs>Add some</a>.",
            array("attrs" => html::mark_clean("href=\"$addurl\" class=\"g-dialog-link\""))) ?></li>
  <? else: ?>
  <li class="span12"><?= t("There aren't any photos here yet!") ?></li>
  <? endif; ?>
<? endif; ?>
</ul>
<?= $theme->album_bottom() ?>

<?= $theme->paginator() ?>

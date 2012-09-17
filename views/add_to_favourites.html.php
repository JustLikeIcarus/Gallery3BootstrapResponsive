<?php defined("SYSPATH") or die("No direct script access.") ?>
<div class="add_to_favourites pull-left">
<a id="favourites_<?=$item->id?>" class="btn btn-mini <?
  $favselected = false;
  if (isset($favourites))
  {
    if($favourites->contains($item->id)){
      ?> btn-inverse<?
      $favselected = true;
    }
  }
?>" href="<?= url::site("favourites/toggle_favourites/$item->id") ?>" title="<?=$favselected?t("Remove from favourites"):t("Add to favourites") ?>"><i class="icon-star <?=$favselected?"icon-white":null; ?>"></i></a>
</div>
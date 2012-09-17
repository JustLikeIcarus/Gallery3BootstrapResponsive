<?php defined("SYSPATH") or die("No direct script access.") ?>
<style>
input[type="text"] {
  width: 95%;
}
</style>
<h1 style="display: none;"><?= t("HTML Code") ?></h1>
<div id="g-embed-links-html-data">
<? $counter = 0; ?>
<? for ($i = 0; $i < count($titles); $i++): ?>    
  <legend><?= t($titles[$i][0]) ?></legend>
          <? for ($j = $counter; $j < $titles[$i][1]+$counter; $j++): ?>    
              <label><?= t($details[$j][0]) ?></label>
              <input type="text" onclick="this.focus(); this.select();" value="<?= $details[$j][1] ?>" readonly>
          <? endfor ?>
          <? $counter+= $titles[$i][1]; ?>      
<? endfor ?>
</div>

<?php defined("SYSPATH") or die("No direct script access.") ?>
<? if (!$menu->is_empty()): // Don't show the menu if it has no choices ?>
<? if ($menu->is_root): ?>
<div class="dropdown">
    <ul <?= $menu->css_id ? "id='$menu->css_id'" : "" ?> class="nav <?= $menu->css_class ?>" role="navigation">    
        <? foreach ($menu->elements as $element): ?>
            <?= $element->render() ?>
        <? endforeach ?>    
    </ul>
</div>

<? else: ?>
<?php if (in_array($menu->id, array('settings_menu','content_menu','appearance_menu','statistics_menu'))) : ?>
<li title="<?= $menu->label->for_html_attr() ?>" class="dropdown-submenu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <?= $menu->label->for_html() ?>            
    </a>

    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
        <? foreach ($menu->elements as $element): ?>
            <?= $element->render() ?>
        <? endforeach ?>
    </ul>    
    
</li>
    <?php else: ?>
<li title="<?= $menu->label->for_html_attr() ?>" class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <?= $menu->label->for_html() ?>    
        <b class="caret"></b>
    </a>

    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
        <? foreach ($menu->elements as $element): ?>
            <?= $element->render() ?>
        <? endforeach ?>
    </ul>    
    
</li>
    
<?php endif; ?>
<? endif ?>
<? endif ?>

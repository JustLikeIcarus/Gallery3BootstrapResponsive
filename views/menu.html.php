<?php defined("SYSPATH") or die("No direct script access.") ?>
<?php if (!$menu->is_empty()): // Don't show the menu if it has no choices ?>
    <? if ($menu->is_root): ?>
        <?php
        $nav = true;
        $nav_list = false;
        $button_group = false;
        $button_dropdown = false;
                
        if ($menu->css_id == 'g-album-menu') :
            $nav = true;
            $nav_list = true;
            $button_group = false;
        elseif ($menu->css_id == 'g-login-menu') :
            $nav = false;
            $nav_list = false;
            $button_group = true;
        elseif ($menu->css_class == 'g-context-menu') : 
            $nav = false;
            $nav_list = false;
            $button_group = false;
            $button_dropdown = true;            
        endif;        
        ?>
        <?php if ($nav) : ?>

        <div <?= !$nav_list ? 'class="dropdown"' : 'class="clearfix"'; ?>>
            <ul <?= $menu->css_id ? "id='$menu->css_id'" : "" ?> class="nav <?= $nav_list ? 'nav-list' : null; ?> <?= $menu->css_class ?>" role="navigation">    
                <? foreach ($menu->elements as $element): ?>
                    <?= $element->render() ?>
                <? endforeach ?>    
            </ul>
        </div>
        <?php else: ?>        
        <div class="btn-group clearfix">
            <?php if ($menu->css_id == 'g-login-menu') : ?><ul <?= $menu->css_id ? "id='$menu->css_id'" : "" ?>><?php endif; ?>
            <?php foreach ($menu->elements as $element) : ?>
                <?= $element->render(); ?>
            <?php endforeach; ?>
            <?php if ($menu->css_id == 'g-login-menu') : ?></ul><?php endif; ?>
        </div>
        <?php endif; ?>
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
        <?php elseif (in_array($menu->id, array('options_menu')) && $menu->css_class != 'normal') : ?>
        <a href="#" class="btn btn-mini dropdown-toggle" data-toggle="dropdown">
            <?=$menu->label->for_html() ?>
            <b class="caret"></b>            
        </a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                <? foreach ($menu->elements as $element): ?>
                    <?= $element->render() ?>
                <? endforeach ?>
            </ul>         
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

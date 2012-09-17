<?php defined("SYSPATH") or die("No direct script access.") ?>
<!DOCTYPE html>
<html <?= $theme->html_attributes() ?> lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <?php $theme->start_combining("script,css") ?>
        <title>
        <?php if ($page_title): ?>
            <?php echo $page_title ?>
        <?php else: ?>
            <?php if ($theme->item()): ?>
                <?php echo $theme->item()->title ?>
            <?php elseif ($theme->tag()): ?>
                <?php echo t("Photos tagged with %tag_title", array("tag_title" => $theme->tag()->name)) ?>
            <?php else: /* Not an item, not a tag, no page_title specified.  Help! */ ?>
                <?php echo item::root()->title ?>
            <?php endif; ?>
        <?php endif; ?>
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" 
          href="<?= url::file(module::get_var("gallery", "favicon_url")) ?>"
          type="image/x-icon" />
        <link rel="apple-touch-icon-precomposed"
          href="<?= url::file(module::get_var("gallery", "apple_touch_icon_url")) ?>" />
        <?php if ($theme->page_type == "collection"): ?>
            <?php if ($thumb_proportion != 1): ?>
                <?php $new_width = round($thumb_proportion * 213) ?>
                <?php $new_height = round($thumb_proportion * 240) ?>
                <style type="text/css">
                .g-view #g-content #g-album-grid .g-item {
                    width: <?= $new_width ?>px;
                    height: <?= $new_height ?>px;
                    /* <?= $thumb_proportion ?> */
                }
                </style>
            <?php endif; ?>
        <?php endif; ?>

        <?php echo $theme->script("json2-min.js") ?>
        <?php echo $theme->script("jquery.min.js") ?>
        <?php echo $theme->script("jquery.form.js") ?>
        <?php echo $theme->script("jquery-ui.min.js") ?>
        <?php echo $theme->script("gallery.common.js") ?>
        <?php /* MSG_CANCEL is required by gallery.dialog.js */ ?>
        <script type="text/javascript">
            var MSG_CANCEL = <?php echo t('Cancel')->for_js() ?>;
        </script>
        <?php echo $theme->script("gallery.ajax.js") ?>
        <?php echo $theme->script("gallery.dialog.js") ?>
        <?php echo $theme->script("superfish/js/superfish.js") ?>
        <?php echo $theme->script("jquery.localscroll.js") ?>

        <?php /* These are page specific but they get combined */ ?>
        <?php if ($theme->page_subtype == "photo"): ?>
            <?php $theme->script("jquery.scrollTo.js") ?>
            <?php $theme->script("gallery.show_full_size.js") ?>
        <?php elseif ($theme->page_subtype == "movie"): ?>
            <?php $theme->script("flowplayer.js") ?>
        <?php endif ?>

        <?php $theme->head() ?>

        <? /* Theme specific CSS/JS goes last so that it can override module CSS/JS */ ?>
        <?= $theme->script("ui.init.js") ?>
        <?= $theme->css("bootstrap.css") ?>
        <?= $theme->css("bootstrap-responsive.css") ?>
        <?= $theme->script("bootstrap.js") ?>
        <?//= $theme->css("yui/reset-fonts-grids.css") ?>
        <?//= $theme->css("superfish/css/superfish.css") ?>
        <?//= $theme->css("themeroller/ui.base.css") ?>
        <?= $theme->css("screen.css") ?>
        <?= $theme->css("font-awesome.css") ?>
        <? if (locales::is_rtl()): ?>
            <?= $theme->css("screen-rtl.css") ?>
        <? endif; ?>
        <!--[if lte IE 8]>
        <link rel="stylesheet" type="text/css" href="<?= $theme->url("css/fix-ie.css") ?>"
              media="screen,print,projection" />
        <![endif]-->

        <!-- LOOKING FOR YOUR CSS? It's all been combined into the link below -->
        <?= $theme->get_combined("css") ?>

        <!-- LOOKING FOR YOUR JAVASCRIPT? It's all been combined into the link below -->
        <?= $theme->get_combined("script") ?>
    </head>

    <body <?= $theme->body_attributes() ?>>
        <div class="container-fluid">    
            <?= $theme->page_top() ?>
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">                
                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>                    
                    
                        <? if ($header_text = module::get_var("gallery", "header_text")): ?>
                            <a href="<?php echo item::root()->url(); ?>" class="brand"><?= $header_text ?></a>
                        <? else: ?>
                            <a id="g-logo" class="brand" href="<?= item::root()->url() ?>" title="<?= t("go back to the Gallery home")->for_html_attr() ?>">
                                <img width="107" height="48" alt="<?= t("Gallery logo: Your photos on your web site")->for_html_attr() ?>" src="<?= url::file("lib/images/logo.png") ?>" />
                            </a>
                        <? endif ?>      
                    
                        <?= $theme->site_menu($theme->item() ? "#g-item-id-{$theme->item()->id}" : "") ?>
                        <div class="nav-collapse">
                            <form action="/index.php/search" id="g-quick-search-form" class="form-search pull-right">
                                <div class="input-append">
                                    <input type="text" name="q" id="g-search" class="span3 search-query" placeholder="<?php echo t("Search the gallery")->for_html_attr(); ?>">
                                    <button type="submit" class="btn"><?php echo t('Search')->for_html_attr();?></button>
                                </div>                                                                        
                            </form>                                                                                   
                        </div>                                      
                    </div>
                </div>
            </div>     
            <div class="row-fluid">
                <div class="g-content span9">                            
                    <?= $theme->messages() ?>
                    <?= $content ?>        
                </div>
                <div class="span3 well">
                    <?= $theme->user_menu() ?>
                    <? if ($theme->page_subtype != "login"): ?>
                        <?= new View("sidebar.html") ?>
                    <? endif ?>            
                </div>
            </div>
            <footer class="row-fluid">
                <div class="span12">
                    <?= $theme->footer() ?>
                    <? if ($footer_text = module::get_var("gallery", "footer_text")): ?>
                        <?= $footer_text ?>
                    <? endif ?>

                    <? if (module::get_var("gallery", "show_credits")): ?>
                    <ul id="g-credits" class="g-inline">
                        <?= $theme->credits() ?>
                    </ul>
                    <? endif ?>
                </div>
            </footer>
            <div class="modal hide fade" id="g-modal" role="dialog" aria-labelledby="g-modal-label" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h3 id="g-modal-label">&nbsp;</h3>
                </div>
                <div class="modal-body">
                
                </div>
                <div class="modal-footer">
                &nbsp;
                </div>
            </div>
            <?= $theme->page_bottom() ?>
        </div>
  </body>
</html>

<?
/**
 * Base template - Home
 *
 * @package    HNG2
 * @subpackage core
 * @author     Alejandro Caballero - lava.caballero@gmail.com
 *             
 * @var template $template
 * @var settings $settings
 * @var config   $config
 * @var account  $account
 */

use hng2_base\account;
use hng2_base\config;
use hng2_base\settings;
use hng2_base\template;
use hng2_tools\internals;

include __DIR__ . "/functions.inc";
$template->init(__FILE__);
$template->set("page_tag", "home"); # This is a very specific case
$account->ping();

foreach($template->get_includes("pre_rendering") as $module => $include)
{
    $this_module = $modules[$module];
    include "{$this_module->abspath}/contents/{$include}";
}

if( $template->get("no_right_sidebar") ) $template->clear_right_sidebar_items();

header("Content-Type: text/html; charset=utf-8"); ?>
<!DOCTYPE html>
<html>
<head>
    <? include __DIR__ . "/segments/common_header.inc"; ?>
    
    <!-- Others -->
    <script type="text/javascript" src="<?= $config->full_root_path ?>/lib/jquery.blockUI.js"></script>
    <script type="text/javascript" src="<?= $config->full_root_path ?>/lib/jquery.form.min.js"></script>
    <script type="text/javascript" src="<?= $config->full_root_path ?>/lib/noty-2.3.7/js/noty/packaged/jquery.noty.packaged.min.js"></script>
    <script type="text/javascript" src="<?= $config->full_root_path ?>/lib/noty-2.3.7/js/noty/themes/default.js"></script>
    
    <!-- Core functions and styles -->
    <script type="text/javascript"          src="<?= $config->full_root_path ?>/media/noty_defaults~v<?=$config->engine_version?>.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= $config->full_root_path ?>/media/styles~v<?=$config->engine_version?>.css">
    <link rel="stylesheet" type="text/css" href="<?= $config->full_root_path ?>/media/admin~v<?=$config->engine_version?>.css">
    <script type="text/javascript"          src="<?= $config->full_root_path ?>/media/functions~v<?=$config->engine_version?>.js"></script>
    <script type="text/javascript"          src="<?= $config->full_root_path ?>/media/notification_functions~v<?=$config->engine_version?>.js"></script>
    
    <!-- This template -->
    <? $css_version = "2.0"; ?>
    <link rel="stylesheet" type="text/css" href="<?= $template->url ?>/media/styles~v<?= $css_version ?>.css">
    <link rel="stylesheet" type="text/css" href="<?= $template->url ?>/media/post_styles~v<?= $css_version ?>.css">
    <link rel="stylesheet" type="text/css" href="<?= $template->url ?>/media/colors~v<?= $css_version ?>.css">
    
    <? if( $template->count_left_sidebar_groups() > 0 ): ?>
        <!-- Left sidebar -->
        <link rel="stylesheet" type="text/css" href="<?= $template->url ?>/media/left_sidebar_addon~v<?= $css_version ?>.css">
        <script type="text/javascript"          src="<?= $template->url ?>/media/left_sidebar_addon~v<?= $css_version ?>.js"></script>
    <? endif; ?>
    
    <? if( $template->count_right_sidebar_items() > 0 ): ?>
        <!-- Right sidebar -->
        <link rel="stylesheet" type="text/css" href="<?= $template->url ?>/media/right_sidebar_addon~v<?= $css_version ?>.css">
    <? endif; ?>
    
    <!-- Always-on -->
    <? $template->render_always_on_files(); ?>
    
    <!-- Per module loads -->
    <?
    foreach($template->get_includes("html_head") as $module => $include)
    {
        $this_module = $modules[$module];
        include "{$this_module->abspath}/contents/{$include}";
    }
    ?>
</head>
<body data-orientation="landscape" data-viewport-class="0" <?=$template->get("additional_body_attributes")?>
      data-page-tag="<?= $template->get("page_tag") ?>" class="home"
      data-is-mobile="<?= is_mobile() ? "true" : "false" ?>"
      data-is-known-user="<?= $account->_exists ? "true" : "false" ?>"
      data-user-level="<?= $account->level ?>">

<div id="body_wrapper">
    
    <?
    foreach($template->get_includes("pre_header") as $module => $include)
    {
        $this_module = $modules[$module];
        include "{$this_module->abspath}/contents/{$include}";
    }
    ?>
    
    <div id="header">
        
        <div class="header_top">
            <?
            if( $settings->get("engine.show_admin_menu_in_header_menu") != "true" )
                include "{$template->abspath}/segments/admin_menu.inc";
            
            foreach($template->get_includes("header_top") as $module => $include)
            {
                $this_module = $modules[$module];
                include "{$this_module->abspath}/contents/{$include}";
            }
            ?>
        </div>
        
        <div class="menu clearfix">
            
            <span id="main_menu_trigger" class="main_menu_item" onclick="toggle_main_menu_items()">
                <span class="fa fa-bars fa-fw"></span>
            </span>
            
            <? if( $template->count_left_sidebar_groups() > 0 ): ?>
                <span id="left_sidebar_trigger" class="main_menu_item pull-left"
                      onclick="toggle_left_sidebar_items()">
                    <span class="fa fa-ellipsis-v fa-fw"></span>
                </span>
            <? endif; ?>
            
            <a id="home_menu_button" class="main_menu_item always_visible pull-left" href="<?= $config->full_root_path ?>/">
                <span class="fa fa-home fa-fw"></span>
            </a>
            
            <?
            if( $settings->get("engine.show_admin_menu_in_header_menu") == "true" )
                add_admin_menu_items_to_header_menu();
            
            foreach($template->get_includes("header_menu") as $module => $include)
            {
                $this_module = $modules[$module];
                include "{$this_module->abspath}/contents/{$include}";
            }
            
            echo $template->build_menu_items("priority");
            ?>
        </div>
        
        <div class="header_bottom">
            <?
            foreach($template->get_includes("header_bottom") as $module => $include)
            {
                $this_module = $modules[$module];
                include "{$this_module->abspath}/contents/{$include}";
            }
            ?>
        </div>
        
    </div><!-- /#header -->
    
    <?
    foreach($template->get_includes("pre_content") as $module => $include)
    {
        $this_module = $modules[$module];
        include "{$this_module->abspath}/contents/{$include}";
    }
    ?>
    
    <div id="content_wrapper" class="clearfix">
        
        <? if( $template->count_left_sidebar_groups() > 0 ): ?>
            <div id="left_sidebar" class="sidebar">
                <? echo $template->build_left_sidebar_groups(); ?>
            </div>
        <? endif; ?>
        
        <div id="content">
            <?
            foreach($template->get_includes("content_top") as $module => $include)
            {
                $this_module = $modules[$module];
                include "{$this_module->abspath}/contents/{$include}";
            }
            
            foreach($template->get_includes("home_content") as $module => $include)
            {
                $this_module = $modules[$module];
                include "{$this_module->abspath}/contents/{$include}";
            }
            
            foreach($template->get_includes("content_bottom") as $module => $include)
            {
                $this_module = $modules[$module];
                include "{$this_module->abspath}/contents/{$include}";
            }
            ?>
        </div><!-- /#content -->
        
        <? if( $template->count_right_sidebar_items() > 0 ): ?>
            <div id="right_sidebar" class="sidebar">
                <? echo $template->build_right_sidebar_items(); ?>
            </div>
        <? endif; ?>
        
    </div>
        
    <?
    foreach($template->get_includes("pre_footer") as $module => $include)
    {
        $this_module = $modules[$module];
        include "{$this_module->abspath}/contents/{$include}";
    }
    ?>
    
    <div id="footer">
        <?
        foreach($template->get_includes("footer_top") as $module => $include)
        {
            $this_module = $modules[$module];
            include "{$this_module->abspath}/contents/{$include}";
        }
        ?>
        
        <div class="footer_contents" align="center">
            <?= $settings->get("engine.website_name") ?>
            <?= replace_escaped_vars($language->powered_by, '{$version}', $config->engine_version) ?>
            •
            <?
            if( $config->query_tracking_enabled ) echo "
                <span class='fa fa-database fa-fw'></span>" . number_format($database->get_tracked_queries_count()) . " •
                ";
            echo "
                <span class='fa fa-clock-o fa-fw'></span>" . number_format(microtime(true) - $global_start_time, 3) . "s •
                <span class='fa fa-tachometer fa-fw'></span>" . number_format(memory_get_usage(true) / 1024 / 1024, 1) . "MiB
            ";
            if($config->display_performance_details && EMBED_INTERNALS)
                echo "• <span class=\"fa fa-plus fa-fw pseudo_link\" onclick=\"$('.internals').show();\"></span>";
            ?>
        </div>
        
        <?
        foreach($template->get_includes("footer_bottom") as $module => $include)
        {
            $this_module = $modules[$module];
            include "{$this_module->abspath}/contents/{$include}";
        }
        ?>
        
    </div><!-- /#footer -->
    
    <?
    foreach($template->get_includes("post_footer") as $module => $include)
    {
        $this_module = $modules[$module];
        include "{$this_module->abspath}/contents/{$include}";
    }
    ?>
    
</div><!-- /#body_wrapper -->

<!-- These must be at the end of the document -->
<script type="text/javascript" src="<?= $config->full_root_path ?>/lib/tinymce-4.4.0/tinymce.min.js"></script>
<? $template->render_tinymce_additions(); ?>
<script type="text/javascript" src="<?= $config->full_root_path ?>/media/init_tinymce~v<?=$config->scripts_version?>.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        tinymce.init(tinymce_defaults);
        tinymce.init(tinymce_full_defaults);
        tinymce.init(tinymce_minimal_defaults);
    });
</script>

<?
foreach($template->get_includes("pre_eof") as $module => $include)
{
    $this_module = $modules[$module];
    include "{$this_module->abspath}/contents/{$include}";
}

internals::render(__FILE__);
?>

</body>
</html>
<?
foreach($template->get_includes("post_rendering") as $module => $include)
{
    $this_module = $modules[$module];
    include "{$this_module->abspath}/contents/{$include}";
}
?>

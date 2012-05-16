<?php
/*
Plugin Name: Yotru
Plugin URI: https://github.com/mahnunchik/wp-yotru
Description: Yotru plugin for WordPress
Version: 0.1.4
Author: Eugeny Vlasenko
Author URI: http://about.me/vlasenko
*/

function activate_yotru() {
  add_option('yotru_api_key', '');
}

function deactive_yotru() {
  delete_option('yotru_api_key');
}

function admin_init_yotru() {
  register_setting('yotru', 'yotru_api_key');
}

function admin_menu_yotru() {
  add_options_page('Yotru', 'Yotru', 8, 'yotru', 'options_page_yotru');
}

function options_page_yotru() {
  include(WP_PLUGIN_DIR.'/yotru/options.php');
}

function yotru_button($content){
    if(is_single()){
        $content.='<div style="display:none;" id="yo-root"></div><button style="background-image:url('.WP_PLUGIN_URL.'/yotru/yotru.png);" id="yotru-button"></button>';
    }
    return $content;
}
function yotru_stylesheet(){
    wp_enqueue_style('yotru', WP_PLUGIN_URL. '/yotru/yotru.css', false, '1.4');
}


function yotru(){
    $api_key = get_option('yotru_api_key');
    global $post;

    if ( empty($post) )
        return false;
?>
<script type="text/javascript" src="http://widget.yotru.com/yotru.js"></script>
<script type="text/javascript">
yotru.init({
    apiKey: "<?php echo $api_key; ?>"
});
jQuery(function(){
    jQuery('#yotru-button').click(function() {
        yotru.addToCart({
           "id": "<?php echo $post->ID; ?>",
           "name":"<?php echo get_the_title(); ?>",
           "price":0,
           "count":1
       });
       yotru.checkout();
    });
});

</script>
<?php
}


register_activation_hook(__FILE__, 'activate_yotru');
register_deactivation_hook(__FILE__, 'deactive_yotru');

if (is_admin()) {
    add_action('admin_init', 'admin_init_yotru');
    add_action('admin_menu', 'admin_menu_yotru');
}

function yotru_js_scripts_on_init(){
    if ( ! is_admin() ) {
        add_action('wp_footer', 'yotru');
        wp_enqueue_script('jquery');
    }
}

add_action('init', 'yotru_js_scripts_on_init');


include(WP_PLUGIN_DIR.'/yotru/yotru-widget.php');

add_action('wp_print_styles', 'yotru_stylesheet');
add_filter( 'the_content', 'yotru_button' );

// Adds link to settings page on plugins page
add_filter( 'plugin_action_links', 'yotru_settings_link', 10, 2 );

function yotru_settings_link($links, $file)
{
    if ($file == plugin_basename('yotru/yotru.php'))
    {
        $links[] = '<a href="options-general.php?page=yotru">' . __('Settings', 'text_domain') . '</a>';
    }

    return $links;
}
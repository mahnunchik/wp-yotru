<?php
/*
Plugin Name: Yotru
Plugin URI: https://github.com/mahnunchik/wp-yotru
Description: Yotru plugin for WordPress
Version: 0.1.3
Author: Eugeny Vlasenko
Author URI: http://about.me/vlasenko
*/

function activate_yotru() {
  add_option('yotru_api_key', 'demo');
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
    $post = get_post();
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

if (!is_admin()) {
    add_action('wp_footer', 'yotru');
}

include(WP_PLUGIN_DIR.'/yotru/yotru-widget.php');  

add_action('wp_print_styles', 'yotru_stylesheet');
add_filter( 'the_content', 'yotru_button' );


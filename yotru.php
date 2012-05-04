<?php
/*
Plugin Name: Yotru
Plugin URI: https://github.com/mahnunchik/wp-yotru
Description: Yotru plugin for WordPress
Version: 0.1
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
  include(WP_PLUGIN_DIR.'/wp-yotru/options.php');  
}


function yotru(){
    $api_key = get_option('yotru_api_key');
?>
<script type="text/javascript" src="http://widget.yotru.com/yotru.js"></script>
<script type="text/javascript">
yotru.init({
   apiKey: "<?php echo $api_key; ?>"
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
<div class="wrap">
<h2>Yotru</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
<?php settings_fields('yotru'); ?>

<table class="form-table">

<tr valign="top">
    <td colspan="2">
        <?php _e('Please, register on Yotru.com website and obtain API key. You could register <a href="http://yotru.com/#register">here</a>.', 'text_domain') ?>
    </td>
</tr>
<tr valign="top">
    <th scope="row">
        Api key:
    </th>
    <td>
        <input type="text" name="yotru_api_key" placeholder="<?php _e('Paste Yotru API key here', 'text_domain') ?>" value="<?php echo get_option('yotru_api_key'); ?>" />
    </td>
</tr>

</table>

<input type="hidden" name="action" value="update" />

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>

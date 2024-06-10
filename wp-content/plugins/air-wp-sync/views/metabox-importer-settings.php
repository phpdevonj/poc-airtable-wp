<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

?>

<table class="form-table">
    <tr valign="top">
        <th scope="row">
            <label for="post_type"><?php esc_html_e( 'Import as', 'air-wp-sync' ); ?></label>
        </th>
        <td>
            <select class="regular-text ltr" name="airwpsync::module" x-model="config.module" x-init="config.module = config.module || $el.value;" @change="updateWordPressOptions();">
                <?php foreach ( $modules as $module ) : ?>
                    <option value="<?php echo esc_attr( $module->get_slug() ); ?>"><?php echo esc_html( $module->get_name() ); ?></option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
</table>
<hr>
<?php foreach ( $modules as $module ) : ?>
    <template x-if="config.module === '<?php echo esc_attr( $module->get_slug() ); ?>'">
        <?php $module->render_settings( $post ); ?>
    </template>
<?php endforeach; ?>

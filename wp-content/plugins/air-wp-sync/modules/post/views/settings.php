<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<table class="form-table">
    <tr valign="top">
        <th scope="row">
            <label for="post_type"><?php esc_html_e( 'Post Type', 'air-wp-sync' ); ?></label>
        </th>
        <td>
            <select class="regular-text ltr" name="airwpsync::post_type" x-model="config.post_type" x-init="config.post_type = config.post_type || $el.value;" @change="updateWordPressOptions();">
				<?php foreach ( $post_types as $post_type ) : ?>
                    <option value="<?php echo esc_attr( $post_type['value'] ); ?>" <?php echo !$post_type['enabled'] ? 'disabled="disabled"' : '' ?>><?php echo esc_html( $post_type['label'] ); ?></option>
				<?php endforeach; ?>
            </select>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="post_status"><?php esc_html_e( 'Default Post Status', 'air-wp-sync' ); ?></label>
        </th>
        <td>
            <select class="regular-text ltr" name="airwpsync::post_status" x-model="config.post_status" x-init="config.post_status = config.post_status || $el.value;">
				<?php foreach ( $post_stati as $post_status ) : ?>
                    <option value="<?php echo esc_attr( $post_status['value'] ); ?>" <?php echo !$post_status['enabled'] ? 'disabled="disabled"' : '' ?>><?php echo esc_html( $post_status['label'] ); ?></option>
				<?php endforeach; ?>
            </select>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="post_author"><?php esc_html_e( 'Default Post Author', 'air-wp-sync' ); ?></label>
        </th>
        <td>
            <select class="regular-text ltr" name="airwpsync::post_author" x-model="config.post_author" x-init="config.post_author = config.post_author || $el.value;">
				<?php foreach ( $post_authors as $post_author ) : ?>
                    <option value="<?php echo esc_attr( $post_author['value'] ); ?>" <?php echo !$post_author['enabled'] ? 'disabled="disabled"' : '' ?>><?php echo esc_html( $post_author['label'] ); ?></option>
				<?php endforeach; ?>
            </select>
        </td>
    </tr>
</table>

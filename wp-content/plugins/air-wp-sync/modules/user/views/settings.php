<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
?>

<table class="form-table">
    <tr valign="top">
        <th scope="row">
            <label for="test"><?php esc_html_e( 'Default role', 'air-wp-sync' ); ?></label>
        </th>
        <td>
            
            <select class="regular-text ltr" name="airwpsync::default_role" x-model="config.default_role" x-init="config.default_role = config.default_role || $el.value;">
                <?php
                    wp_dropdown_roles( get_option( 'default_role' ) );
                ?>
            </select>
        </td>
    </tr>
    <?php
		$languages = get_available_languages();
		if ( $languages ) : ?>
            <tr valign="top">
                <th scope="row">
                    <label for="test"><?php esc_html_e( 'Language', 'air-wp-sync' ); ?></label>
                </th>
                <td>                    
                    <?php
                        echo str_replace(
                            '<select name=',
                            '<select class="regular-text ltr" x-model="config.default_locale" x-init="config.default_locale = config.default_locale || $el.value;" name=',
                            wp_dropdown_languages(
                                array(
                                    'name'                        => 'airwpsync::default_locale',
                                    'id'                          => 'airwpsync_default_locale',
                                    'selected'                    => 'site-default',
                                    'languages'                   => $languages,
                                    'show_available_translations' => false,
                                    'show_option_site_default'    => true,
                                    'echo'                        => 0,
                                )
                            )
                        )
                    ?>
                </td>
            </tr>
    <?php endif; ?>
	<tr valign="top">
		<th scope="row"><?php _e( 'Send User Notification', 'air-wp-sync' ); ?></th>
		<td>
			<input type="checkbox" name="airwpsync::send_user_notification" id="send_user_notification" x-model="config.send_user_notification" value="1" />
			<label for="send_user_notification"><?php _e( 'Send the new user an email about their account.' ); ?></label>
		</td>
	</tr>
</table>

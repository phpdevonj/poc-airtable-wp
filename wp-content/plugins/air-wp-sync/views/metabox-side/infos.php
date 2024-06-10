<h4><?php esc_html_e( 'Last Sync Status', 'air-wp-sync' ); ?></h4>

<p class="<?php echo esc_attr( $status_class ); ?>">
    <?php if ( $status === 'success' ) : ?>
        <?php esc_html_e( 'Successful!', 'air-wp-sync' ); ?>
    <?php elseif ( $status === 'error' ) : ?>
        <?php esc_html_e( 'Error', 'air-wp-sync' ); ?>
    <?php elseif ( $status === 'cancel' ) : ?>
        <?php esc_html_e( 'Canceled', 'air-wp-sync' ); ?>
    <?php else: ?>
        --
    <?php endif; ?>
</p>

<?php if ( $status === 'error' && $last_error ) : ?>
    <p class="airwpsync-last-error"><?php echo esc_html( $last_error ); ?></p>
<?php endif; ?>

<h4><?php esc_html_e( 'Last Sync', 'air-wp-sync' ); ?></h4>
<p>
    <?php if ( $last_updated ) : ?>
        <?php echo \Air_WP_Sync_Free\Air_WP_Sync_Helper::get_formatted_date_time( $last_updated ); ?>
    <?php else : ?>
        --
    <?php endif; ?>
</p>
<template x-if="config.scheduled_sync.type === 'cron'">
    <div>
        <h4><?php esc_html_e( 'Scheduled Next Sync', 'air-wp-sync' ); ?></h4>
        <p>
            <?php if ( $next_sync ) : ?>
                <?php echo \Air_WP_Sync_Free\Air_WP_Sync_Helper::get_formatted_date_time( $next_sync ); ?>
            <?php else : ?>
                --
            <?php endif; ?>
        </p>
    </div>
</template>

<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
?>
<div id="airwpsync-metabox-mapping"
     data-value="config.mapping"
     data-name="mapping"
     :class="{'airwpsync-field--invalid': hasErrors('mapping')}"
     data-rules='<?php echo esc_attr( wp_json_encode($mapping_validation_rules) ) ?>'
></div>
<?php do_action( 'airwpsync/metabox/after_mapping', 'manage_options' ); ?>

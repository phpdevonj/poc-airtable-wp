<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'airtable_wp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
define( 'WP_ENVIRONMENT_TYPE', 'local' );
/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'nVz/b0=(Mg_y0zC`vYW)D PJ-nyb]6aRX3,Gt3%,h~!cG(Q0m(K3$JD)rb?fSIHl' );
define( 'SECURE_AUTH_KEY',  '9&VOX8#|iE^rY.pm{7a6v LY|Ak6v%V&p!pKO]^8fK7H|Ov}9[x=&=F4]{>Pc0(J' );
define( 'LOGGED_IN_KEY',    'Im2`Czzl*xNNYB:*g~,3K ;6hSZ<5mE/;HT 1cn.dbtlCu{&X?fhH@v(R2[VM()j' );
define( 'NONCE_KEY',        '6|F)aauyTK|Dgjp<Kj*(mxp-G4llY%-,EwF?UYz!7G_Kqc`vS+48eo|gy(Ia~,i=' );
define( 'AUTH_SALT',        'fiC#71Nb{r*1WVq]ika(PK>W}b8m36@[QAu!VuO6+z[a6N-2Y!.0E=9WJFIm]Y?#' );
define( 'SECURE_AUTH_SALT', '@:!4Uiw?T`}U~3,^)&Q&@u#o9y7 *A^`jW<@mG.<g*|7lQHZ<(eidbcX%iyqlcr=' );
define( 'LOGGED_IN_SALT',   '@0(,r54AZSK)C%6vVgn3{P:m0>.kcIPFj(artqpIf?gWQ=ULqt4XW[fOM+])]HXk' );
define( 'NONCE_SALT',       'k|Rl`*%DB/nTat0B0p#>FET.E#:1])%s3cqY[ry83yhBXpYR(=bej@.[l$#HWP<#' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

define('FS_METHOD', 'direct');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


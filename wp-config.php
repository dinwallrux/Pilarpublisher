<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'pilarpub_wp271' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'pt2m5z7k1wgtg8xlmr0arfi3zvojyvs25akhuvm67llasclra0jjlhjks7oj5rpd' );
define( 'SECURE_AUTH_KEY',  '6l2vn4c93gi1yntvmog7guyfc6zyfaqgnqhoujsjilrbzcuiwuvqk9gaxydeo1cq' );
define( 'LOGGED_IN_KEY',    'wqzzloq016ctdzh2np3uckdcnvmiqprwpcgdfckvbxvzaioi6mo84ioidluoov8l' );
define( 'NONCE_KEY',        '7e7vkjag4a8uu5un1iklbqfszrcz9mpfefvfeco7jmdrdjmdzsb50s6p8ao5bbbh' );
define( 'AUTH_SALT',        'my8zedqvzxu9tjbcm4nkjbt5o3czpqskgzgjdrxgeeoxwfr8b0lt0uatwv9ab5yd' );
define( 'SECURE_AUTH_SALT', 'fdyhidgsxqvtlkigtwk0rd40jdecwi8kbd1cfu2zzl2kununxmftgvvt0jlcpv2g' );
define( 'LOGGED_IN_SALT',   'oagcpj4q6ou06lh5tc8bwkgb30cvcnaexgu6sirxlrys6tv2pnt9y5juwtrtav71' );
define( 'NONCE_SALT',       'xpcwr1lipafvsaghmenjsnygyteqxkhptmttn2rwlrhofqt4kccl9kxdz7fpihtk' );

/**#@-*/

// define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/pilarpublisher');
// define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] . '/pilarpublisher');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wps5_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

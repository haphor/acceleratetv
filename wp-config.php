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
define( 'DB_NAME', 'wipdb' );

/** MySQL database username */
define( 'DB_USER', 'wipuser' );

/** MySQL database password */
define( 'DB_PASSWORD', 'wX4hdYDGfmHtXXtA' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',         'F5:~2Np7w0YpgXp@^t=8cbmy:0 J3Z2FmYd]#mwmL*6n>0z$K%maTx@~cfEv~(S ' );
define( 'SECURE_AUTH_KEY',  '1166,Y]%tKT&2h`2-7:sFlN*{)A>DKL)&?6hPDwF8+bJ+$~v;pUgu,&+5)pfu^HD' );
define( 'LOGGED_IN_KEY',    ' rfcFcJ5-Y@J,DU<Z`Y},q;@bu.|1L#eg2ZF7f2Z=,%fcjq%Z?63wnF|w2=:.e6,' );
define( 'NONCE_KEY',        '8zXhX&Zi,Is;^v dL;6MD0kC|B?kmun|*i1-KH L=}*Nq~a=1l#I$IyCt;]w/m#}' );
define( 'AUTH_SALT',        'oSArs2_+V2MSKBkXv4-%ZJ.>4,vyoS!e6n1MhULGY*gQRJ6O2r)T&+FkD:$vP}OJ' );
define( 'SECURE_AUTH_SALT', 'e!KdOj?$hs lniQpn_rnT<j<2moL~S#C[nkv=@4A]6iR&Z*UOMN4UtZOV%wWO)Y6' );
define( 'LOGGED_IN_SALT',   'uaD!B}G5nj5*FYwyxf_hG0 GT 1R&4brN7<+W^c829zZ.I>1PIEToRv:KJ2 m=I|' );
define( 'NONCE_SALT',       'C`dyN$6o nf}hM%s~f%D1H2+vJB&?DT>@E,%[875+fhefCo^`wVS!-e6k<ozsFa ' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );
define( 'FS_METHOD', 'direct' );
define( 'WP_MEMORY_LIMIT', '128M' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

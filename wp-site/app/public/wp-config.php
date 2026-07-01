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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',          'jAR{xQ9s-WFg38M :jYk|gDp$=$YB|H{)7Oc`qZisZ+#Qn<J[:!;_I{uu22$(Oh|' );
define( 'SECURE_AUTH_KEY',   '2K;XR;IrJ|IHv&V{8og$u%1hpXaa+?(&[3{vzy*S%;D]`+KfmSH6jz/jyM&WXwiE' );
define( 'LOGGED_IN_KEY',     'AU}I_Y>>jV@TnD}KU.br8Y1%>q/Xo3VTm:b9^[fy8iMo^99+N3i; ]<U/Ga}JP=C' );
define( 'NONCE_KEY',         'b7+&|i+=.{3,;#>~;2A#mJ-/=G20b,7N,zlQ)pKS%[ Pj!*Vjq}X`^&S|)|H/kn3' );
define( 'AUTH_SALT',         '@Y2F#Env$[Bt.X#BY|V@}kt!Rwxf%e[[$kY^zdnPp]CLZ%vgCPQ<zAHKtH1fDmc}' );
define( 'SECURE_AUTH_SALT',  '`??ZMbSU/=<np7D^r,5#7E}HJ4;id)%xH~%T$UpYAR2(auS}x+VK>vF=6GeS!)tl' );
define( 'LOGGED_IN_SALT',    '1.8 LK#w:=0PNDh>28l_P!}@9g>^$d=W?@-ap.;/VA4G1.Pxq:([JO<ji#(@LYNo' );
define( 'NONCE_SALT',        'rXUcnl)N?9Xz;xTeLmE>SX0qCE7YPL<Ol kX`h1(93TU?A[.IR@6NXanbAD&tfOF' );
define( 'WP_CACHE_KEY_SALT', 'YYSu{&mV1lyp]X.ZU@!ef.5W-x/.*c4{<u];J|?e^f.>Y8A)[R*#g)h 5so;;_N4' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

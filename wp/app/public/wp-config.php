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
define( 'AUTH_KEY',          'X>p!Vj%uDR4GhSOq6d2=t*cc%d(Q}RwNf,9`p%zTr30&$]I,d;rjsegf $;)Cb7o' );
define( 'SECURE_AUTH_KEY',   '2#C2B-jm{^}BT#Dg>SH~#%mGAM(c(* ylsfVX(ojaQrg]y_$FNIsyAI$S`J@lp^_' );
define( 'LOGGED_IN_KEY',     'c&b2w)r7mf!gClGXOQCU:,4 VS^!nU6#J7.W:#xap@y$vuN@ut/HWgE<!);2tA)F' );
define( 'NONCE_KEY',         ')|P]}8Uq2I#tUo(-ZdD+C0g^>2SMOOU1n3D(TlajwdW08bZ*tXb.-Pnzu&F}+uZY' );
define( 'AUTH_SALT',         'y{Hmgu`_73>xH)sHMDhxp(2x{7oyqT+R^];H(,yka{usp~i=a{|_Gga.`h1yNAtC' );
define( 'SECURE_AUTH_SALT',  'H[(779aui{A&]RZ+qZ;)a[S;Q?,9%83;~R_ve_I~sm?RpV~yA&gMXB!ls#S4ypVc' );
define( 'LOGGED_IN_SALT',    'q;A89xX+ /Q`o_Dl8|hFLAGWwdn;EsW4E7b.me]f64+t<3Xu]Z}.Qaga5-Hc.C,[' );
define( 'NONCE_SALT',        'Xs6csZXW56-W[k6a4~SF>C]i X6uSI1BF]Y%12q|IUU_AILsS;*{h9,{lsJPv0CI' );
define( 'WP_CACHE_KEY_SALT', 'N|kGiE^detd);y2m:KC~Dc(;tETqbZ9J3$f#-P1B@^W<;T,l4uJ@1*drV|cCI?Tn' );


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

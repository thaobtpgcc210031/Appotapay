<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wpweek3' );

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
define( 'AUTH_KEY',         'X.)0W1Le:V9R<{ |umx OmS-ETa}zFccwvN-J#i+t4Q8T]#V*:_tTT$iexGpYiRA' );
define( 'SECURE_AUTH_KEY',  '60@Y[7xnUkl*nP~RW4jH$%o]qng]5In%f[/%JE^OXF,eh$HX~k^~@v?J8tc8Hh,u' );
define( 'LOGGED_IN_KEY',    'Xc^DoNutc7Qz31++>-ucvKz(eE]qP=Sjb`WNgn{a82]=MU3(}vI>dhR99j83Qld:' );
define( 'NONCE_KEY',        'R5%(mtrYY?}sbGW&?67!P)WQZM0FT>lQQs$V;]S{?sfr+v9rb0%|LE5J8|)ZT)#S' );
define( 'AUTH_SALT',        '<O#c=8ZDEA*zYY~G&cJdZ{iJuW~A`Fq73pS.I3a!6p6/lEqm>?qjOOsbAZ%G}F?`' );
define( 'SECURE_AUTH_SALT', '=Yd`Q4{B.5u7DwS) 11[2qvWzmhcLu*9)]*R!F9dTUv^51<6nZ4ju5<O8u.Z >|w' );
define( 'LOGGED_IN_SALT',   '.FjL_2:v-CF**_{(M?hc_sWr:ywy<?[1oAYOe_g(P0epzrCRZ!fg>6zUx4`kCV;e' );
define( 'NONCE_SALT',       'LSRUt^3%TpOlRwy:?z3Sx68:[+x[agh_XH5etcQh3d/@>Cc1>;YMq(Lg.xwH7IEW' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

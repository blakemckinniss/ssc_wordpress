<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'bl537804');

/** MySQL database username */
define('DB_USER', 'bl537804');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'soty_Q%}SY@Mk9S9A=>wMe/dJ-puIT9?DBk6Zk1!1gS@UP} 6@zx[a(#-60ZP60^');
define('SECURE_AUTH_KEY',  'v?evZBdTFRA+~0=<FboYu:kE)KUEN%?CpY,d~LA=u1Efx?}<O.NWQxgzLUv`H_{,');
define('LOGGED_IN_KEY',    '0t7DE ~iwvycfQVF47j:9V^/%g2.~@4z::R}B=gdy)57`tTvj5+/$CP,n:dn5ICo');
define('NONCE_KEY',        '?a)oFM*@qDX-k:o-)DkXI^1K$_sD[P.lo8I,*-f b/)^ifUkBjCP>TEQ{^zyNPqd');
define('AUTH_SALT',        '|r1w <Wv tBH69MlNkoeX L5`Ix]KvB&F~$`&qLXb0[6iR:zA+T!59cGs}Q*Uxgc');
define('SECURE_AUTH_SALT', 'Gl KiyN]K=NGiiXn[2PMV0_-69HT&N5,[+U+s 9*jn*=-UYTv+^Y&A[#[p#8<V-O');
define('LOGGED_IN_SALT',   'jHm{:Y<^~vm6IGh!7kbZ?j58-UnY`+AD1UQ6-+xZ7;ZRsA^rN-dY9Z[K#d9R!JR8');
define('NONCE_SALT',       'gY}1}~jj-+aOkw8]vapFDV)*FS({zY2-M-1|$QlIo@<9B8T9#=Mm1_$:6E:F|{|2');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

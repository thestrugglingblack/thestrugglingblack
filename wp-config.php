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
define('DB_NAME', 'thestrugglingblack');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'Rj9ou)c-&K!?~$2 Hit38I 0N{k@4O8~aS@zNn{ZT10n^!>i+fcHo[Jn1Qo,|o*k');
define('SECURE_AUTH_KEY',  '4zAV5qeTu[dqJ}GEC4O<wi(`T0dSFs8oknVDDEXvPn;i^B]O0OI~op/9amJ **R.');
define('LOGGED_IN_KEY',    'U7.={6Mw;@5}$?&)z5:1pPV9aAp{/Gx/&[gn,C me(d2}eO8if2-mr;6xRJ_8f p');
define('NONCE_KEY',        '9Z_%#SO*-P9,J@]M})v>3~Qz#zg:C7wM&N?PquV&@?<<Um(*VQ,:=]^08/E`g{CS');
define('AUTH_SALT',        'U=i7o4WbIZ$ZQl+d4l@KSGnX!1/@Z{B9slhc&,p%LvLq@-?;b{|!iV*P1aP &2y5');
define('SECURE_AUTH_SALT', 'MNo0]-HfQQDA$H6U!2J%sdW1i%$_a y~E~r#z&LzSe& .&V`w-igf/m]r=/sCAq(');
define('LOGGED_IN_SALT',   'X8;e#l{g)HU$pib{mu]R&HhfN;yXBcWD~-dsb&YA~aD/oI>..5!MEV_DsV4VHZV[');
define('NONCE_SALT',       '$j6`s;Z9._%O{pCOTt=/%,<9/ CT@>6ApYBcDKQ`(3W_f:L4Fy[0Y3=_9RR2([;`');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Heroku Postgres settings - from Heroku Environment ** //
$db = parse_url($_ENV["DATABASE_URL"]);

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', trim($db["path"],"/"));

/** MySQL database username */
define('DB_USER', $db["user"]);

/** MySQL database password */
define('DB_PASSWORD', $db["pass"]);

/** MySQL hostname */
define('DB_HOST', $db["host"]);

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
define('AUTH_KEY',         '^d`.3D*k&UO#@5$l^xDVCt`7k6w)MKn|C~|]3@2AOYR!IP lEvU{QvyR@F.q<+N.');
define('SECURE_AUTH_KEY',  'nn.[S_:dz_5wq`_(pSAyMi[>jvyNoHOzB5z7;a_?+,hBlH&,Uv.`# oq7zEqE<+S');
define('LOGGED_IN_KEY',    'XkiSA+#p=!MU3S,ds,ycb$wKg(*@/{^uW(Ah}ec Ivb:fUf{pD%2uZAkYgsvvGM[');
define('NONCE_KEY',        '94J~UU|#la-[bLj|}uC3,iCVl210Wkis~:yzq&Wlx Z|oZk>6*qG%,0bE ]EMhH~');
define('AUTH_SALT',        'cNRG#}ixu*d1+-m]Q^u{l7}?hkr&-|7Meh:|&^,Vh:e|P4x~8Axor9UCvJVLt-!1');
define('SECURE_AUTH_SALT', '8G1[iD+-&m-X_00X]0o8jQF;@cW@QR>t}lv_fA+p+KVpi,-yOxS#K:?Ex6FNow;:');
define('LOGGED_IN_SALT',   'Ote-/UDGw`+m6KdB*XZ5Ya|DR!kPXUuoj0-JLU_B`}k]a*Qxb)`nPr.Mr1G5FnA=');
define('NONCE_SALT',       '}x3HiuE@2Q|=]@Y1!OHv?,cjpXYGl=1!*QDTGi2|s4-w|YkrKEkOJ?&/YvVtwB=K');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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

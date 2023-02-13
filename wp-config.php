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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'fictional-university');

/** Database username */
define('DB_USER', 'root');

/** Database password */
define('DB_PASSWORD', '');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY',         '0H`_Nl3cu8E|Ps&Kc*LdU8$CD+&8C#3,oBKkJ+J>3le-<EdQaL&Dc,KL]&,D#I)W');
define('SECURE_AUTH_KEY',  'ALI=*!9U*`HX!d^5;mPYy(Q-o~$h3vziVG{qAWT8#aN!%1fXW(iXbW(sS;|OGu+F');
define('LOGGED_IN_KEY',    '{JA5nF6j0{`,6eZ8|PmPHc@OsTlhO#C5M^5&0-DZB~<56+PE]2HmbMb Hs<Dn-7#');
define('NONCE_KEY',        'LM4]I{|D@?>41Td}w7mXUUv@$sq/Z,OO3,m32`9?RnuS%c{UBC6i&/md3}hZAwW#');
define('AUTH_SALT',        '>lRayU nox17mm.lg$!{r@Sq^T6cPj0LSb]3x~g9<49VWH{$w-o:!4N6(nCdJ_!T');
define('SECURE_AUTH_SALT', 'm5]b*.cXsPzB8=+;3fY,A 6=@r$_43cB^69>c,lxnS;-un]*X(`rF*;3!n9i$G=<');
define('LOGGED_IN_SALT',   's?g;^XnrZn=n6mZ=h.4RB~,j2 EdNE^4)g,|lfE&)`o@8j:F->O*M;1A9)]D|Irj');
define('NONCE_SALT',       '&N{jxyu-rqR)V`-o8it^h/ kwA-~g0(hI;<4~*3H}?s9}E)i2t=l[3S0UPMARL:X');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'fu_';

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
define('WP_DEBUG', true);

/* Add any custom values between this line and the "stop editing" line. */
// Enable Debug logging to the /wp-content/debug.log file
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', 0);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

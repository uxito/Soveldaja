<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
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
define('DB_NAME', 'd49856sd97357');

/** MySQL database username */
define('DB_USER', 'd49856sa94607');

/** MySQL database password */
define('DB_PASSWORD', '86dHq28X3w9VQXa8P');

/** MySQL hostname */
define('DB_HOST', 'd49856.mysql.zone.ee');

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
define('AUTH_KEY',         'yfEbX1hDxZrzG6iI1gbdXaincxprQZApn2xz26ZR5ScY1OQfoVMAqHPdZyrEzTAI');
define('SECURE_AUTH_KEY',  'Hb1KaL7HN7qyMY9s6j82KLD1zq83drSZksjMNCIn712ZOTuz7CsqHInkB9nw9OJY');
define('LOGGED_IN_KEY',    'MKuuO6Qik8wYHqj2S9JoGBA7FWYcTXaZ4VT9GmvqkIcqD1sTeYbhlzQv0aY9XvlQ');
define('NONCE_KEY',        '9DAs6jmDdzL7K6X9aMAPdQeZjrLUF457zIBQ99j3tPU4FXS6pqAxDy0MezdSDI2z');
define('AUTH_SALT',        'F4fs8sI3MjlaEebT1Mp56csdplGfrHKkqNN5pYzrzQijirZ81PDkrQc51GctWt18');
define('SECURE_AUTH_SALT', 'vJ8YNufMtxAtMUlaFN9nHOK2aeJtJa4S81es1EvbD8DwxuhEBU0Qt43426ycMJfD');
define('LOGGED_IN_SALT',   'aiyE4GykmzmJ68wdUzRDddPqQzE82BnANBRf8xtEG1nnFRDxJy9wqjSxUWgFcNdv');
define('NONCE_SALT',       '5QLPzc905GPpaU0ha1k3CZFEjNHJsQshRNNB7lG1KqEqEcdS3kacG1HgnSH4vUut');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'jyx3_';

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

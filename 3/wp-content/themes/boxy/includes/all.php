<?php
/**
 * Enqueue Scripts and Styles
 */
require_once BOXY_INCLUDES_DIR . '/enqueue.php';

/**
 * Implement the Custom Header feature.
 */
require BOXY_INCLUDES_DIR . '/custom-header.php';

/**
 * Custom functions for this theme.
 */
require BOXY_INCLUDES_DIR . '/theme-functions.php';

/**
 * Custom template tags for this theme.
 */
require BOXY_INCLUDES_DIR . '/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require BOXY_INCLUDES_DIR . '/extras.php';

/**
 * Load Redux Framework
 */
require_once BOXY_PARENT_DIR . '/admin/admin-init.php';

/**
 * Load Theme Options
 */
require_once BOXY_INCLUDES_DIR . '/theme-options-config.php';

/**
 * Load Sane Defaults
 */
require_once BOXY_INCLUDES_DIR . '/home-info.php';

/**
 * Load Sidebars
 */
require_once BOXY_INCLUDES_DIR . '/sidebars.php';

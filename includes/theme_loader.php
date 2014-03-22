<?php
/**
 * Include the custom backend functions for use
 * throughout the theme settings and setup.
 */
require 'backend/theme_functions.php';

/**
 * Includes the standard settings for the theme.
 * This must always be included.
 *
 * @Adding Support for post thumbnails, and menu support.
 * @Adding One main navigation.
 */
require 'backend/theme_core_setup.php';

/**
 * Enables the theme settings menu item.
 * In there you can see a description for adding more
 * items and settings to the menu item. By default
 * these are added:
 *
 * @Adding Support for theme logo, and backend logo.
 * @Adding Support for Google Analytics.
 *
 */
require 'backend/theme_settings.php';

/**
 * Includes the custom theme frontend functions
 */
require 'frontend/theme_functions.php';

/**
 * Includes the custom functions related to the default contact form
 */
require 'frontend/contact_form_functions.php';

/**
 * Includes the Advanced Custom fields plugin
 */
require 'shared/acf.php';

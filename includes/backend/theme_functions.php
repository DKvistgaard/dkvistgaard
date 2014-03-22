<?php
/**
 * File that contains all of the custom backend functions for the template
 */

/**
 * Gets the id of an attachment by the attachment guid
 *
 * @param string $guid
 * @return int attachment_id|null
 */
function get_attachment_id_by_guid($guid) {
    global $wpdb;
    $attachment_id = $wpdb->get_row($wpdb->prepare("SELECT ID FROM `wp_posts` WHERE guid = %s", $guid));
    if($attachment_id->ID){
        return (int)$attachment_id->ID;
    }
    return null;
}

/**
 * Changes the link of the login logo to the blog url
 * @return string|void
 */
function custom_login_headerurl() {
    return get_bloginfo('url');
}

/**
 * Get the current theme logo via wp_get_attachment_image_src
 *
 * @param string $size Optional, default is 'full'.
 * @param bool $icon Optional, default is false. Whether it is an icon.
 * @return bool|array Returns an array (url, width, height), or false, if no image is available.
 */
function get_theme_logo($size='full', $icon = false) {
    $attachment_id = get_attachment_id_by_guid(get_option("theme_logo"));
    return wp_get_attachment_image_src($attachment_id, $size, $icon);
}

/**
 * Adds classes to first and last items in navigation
 * @param $output
 * @return mixed
 */
function add_first_and_last($output) {
    $output = preg_replace('/class="menu-item/', 'class="first-menu-item menu-item', $output, 1);
    $output = substr_replace($output, 'class="last-menu-item menu-item', strripos($output, 'class="menu-item'), strlen('class="menu-item'));
    return $output;
}
add_filter('wp_nav_menu', 'add_first_and_last');

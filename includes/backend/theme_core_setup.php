<?php
/**
 * Sets up theme defaults and registers the various WordPress features that
 * the HTML24 Theme supports.
 *
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses add_theme_support() To add support for post thumbnails.
 *
 */
add_action( 'after_setup_theme', function () {
    // This theme uses wp_nav_menu() in one location.
    register_nav_menu( 'primary', 'Main Navigation');
    add_theme_support( 'post-thumbnails' );

    // Print the analytics tracking code at the wp_footer tag, calling the print_tracking_code function
    add_action('wp_head', 'print_tracking_code');
});

/**
 * Register and load any scripts your theme requires.
 * In this example we will load a script.js with a dependency on jQuery.
 */
add_action('wp_enqueue_scripts', function () {
    // Register our script with and assign dependencies
    wp_register_script(
        'theme-script',
        get_template_directory_uri() . '/js/scripts.js',
        array(
            'jquery'
        )
    );

    // Enqueue script for output
    wp_enqueue_script('theme-script');
});

/**
 * Setting up the backend to use the custom admin image if there is one.
 * If the user hasn't uploaded a custom image, the default wp logo will be
 * used
 */
add_action('login_head', function () {
    if(get_option('theme_backend_logo')) {
        // Get the attachment id of the custom image
        $attachment_id = get_attachment_id_by_guid(get_option('theme_backend_logo'));
        $attachment_image_array = wp_get_attachment_image_src($attachment_id, 'medium');

        // Add the custom link to the new logo
        add_filter('login_headerurl', 'custom_login_headerurl');
        ?>
    <style>
        body.login #login h1 a {
            background: url('<?php echo $attachment_image_array[0]; ?>') no-repeat scroll center top transparent;
            height: <?php echo $attachment_image_array[2]; ?>px;
        }
    </style>
    <?php
    }
});

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
add_filter( 'wp_title', function ( $title, $sep ) {
    if (is_feed()) {
        return $title;
    }
    // Add the site name.
    $title .= get_bloginfo( 'name' );
    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title = "$title $sep $site_description";
    }
    return $title;
}, 10, 2 );

/**
 * Add backend.css stylesheet, which can be used for custom styling
 * elements in the wordpress backend
 * Call stylesheet on admin init
 */
add_action('admin_init', function ()
{
    wp_register_style(
        'theme_backend_styles',
        get_template_directory_uri() . '/css/backend.css'
    );
    wp_enqueue_style('theme_backend_styles');
});

/**
 * Removing unnecessary admin pages which is not used for the theme.
 * By default the editor and comments are disabled.
 * You can customize as you want.
 *
 * If you want to delete more pages just use one of functions below
 * Codex: http://codex.wordpress.org/Function_Reference/remove_menu_page
 *
 */
add_action('admin_init', function()
{
    if (!defined( 'DOING_AJAX' ) || !DOING_AJAX) {
        remove_submenu_page('themes.php', 'theme-editor.php');
        remove_menu_page('edit-comments.php');
    }
});


add_filter( 'excerpt_length', function() {
    return 17;
}, 999 );
add_filter('excerpt_more', function() {
    return '... <a href="'. get_permalink(get_the_ID()) .'">Read more</a>';
});

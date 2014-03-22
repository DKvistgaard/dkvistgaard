<?php
/*************************************************************
 * HTML24 Theme settings
 * In this file you can create new settings pages for the
 * backend, create new fields in existing settings pages
 *
 *************************************************************/

/**
 * admin_menu Hook to create the custom theme settings menu.
 *
 * You can add new submenu items to the settings menu item with this function:
 * add_submenu_page(
 *    $parent_slug,
 *    $page_title,
 *    $menu_title,
 *    $capability,
 *    $menu_slug,
 *    $function
 * );
 *
 * Add the add_submenu_page function into the anonymous function inside the admin_menu action
 * Codex: http://codex.wordpress.org/Function_Reference/add_submenu_page
 */
add_action('admin_menu', function ()
{
    /**
     * Adding the main menu item, called theme settings
     * Calls the function "theme_settings_page" to generate
     * the settings page
     */
    add_menu_page(
        'Theme Settings',
        'Theme Settings',
        'create_users',
        'theme-settings',
        'theme_settings_page',
        'div',
        85
    );

    /**
     * Adding the submenu item to the theme-settings menu item
     * Calls the analytics_sub_page() function to generate the page.
     */
    add_submenu_page(
        'theme-settings',
        'Analytics',
        'Analytics',
        'create_users',
        'theme_analytics',
        'analytics_sub_page'
    );

    /**
     * Adding the submenu item to the theme-settings menu item
     * Calls the contactform_sub_page() function to generate the page.
     */
    add_submenu_page(
        'theme-settings',
        'Contact Form',
        'Contact Form',
        'create_users',
        'theme_contact_form',
        'contactform_sub_page'
    );

    /**
     * Here you can add more submenu pages if needed
     */
});

/**
 * Enqueue needed scripts to create the media uploader for the site logos
 *
 */
add_action('admin_print_scripts', function () {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
});

add_action('admin_print_styles', function () {
    wp_enqueue_style('thickbox');
});

/**
 * Function for rendering the general settings page.
 * It displays a table with theme logo and theme backend logo,
 * and saves the new values when form is submitted at option
 * values.
 *
 * You can choose to add new settings as table rows inside this
 * function like this:
 *
 *
 * <tr>
 *     <th>
 *         <label>Option Label</label>
 *     </th>
 *     <td>
 *        <input id="theme_option" type="text" size="36" name="theme_option" value="" />
 *         <p class="description">Please add a description of the field, but it is optional</p>
 *     </td>
 * </tr>
 *
 *
 * Remember to add the new filed to the update_option method below when the form has been submitted.
 */
function theme_settings_page() {
    if(isset($_POST['submit'])) {
       // Form has been submitted, save the settings meta. Input will be escaped by WP
       update_option("theme_logo", $_POST['theme_logo']);
       update_option("theme_backend_logo", $_POST['theme_backend_logo']);
    }
    ?>
    <div class="wrap">
        <h2>General Settings</h2>
        <?php
        if(isset($_POST['submit'])) {
            ?>
            <div id="setting-error-settings_updated" class="updated settings-error">
                <p><strong>Theme settings saved.</strong></p>
            </div>
            <?php
        }
        ?>
        <p>Here you can edit the general setting for the theme</p>
        <form method="post">
            <script language="javascript">
                /**
                 * Jquery for enabling the custom media uploader
                 */
                jQuery(document).ready(function() {
                    var clicked_button_input_data = '';
                    jQuery('.logo_button').click(function() {
                        clicked_button_input_data = jQuery(this).attr('data_text_input');
                        formfield = jQuery(this).siblings('input[type=text]').attr('name');
                        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
                        return false;
                    });
                    window.send_to_editor = function(html) {
                        console.log(html);
                        imgurl = jQuery(html).attr('href');
                        jQuery('#'+clicked_button_input_data).val(imgurl);
                        var logo_wrapper = jQuery('#'+clicked_button_input_data+"_wrapper");
                        logo_wrapper.html("<img src='"+ imgurl +"' height='100' />");
                        tb_remove();
                        clicked_button_input_data = '';
                    }
                    jQuery('.remove_logo').click(function(){
                        var image_type = jQuery(this).attr('data_logo_type');
                        jQuery('#'+image_type+"_wrapper").find('img').remove();
                        jQuery('#'+image_type).val('');
                    })
                });
            </script>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th>
                            <label>Theme Logo</label>
                        </th>
                        <td>
                            <input id="theme_logo" class="button" type="hidden" size="36" name="theme_logo" value="<?php echo get_option('theme_logo'); ?>" />
                            <input id="theme_logo_button" data_text_input="theme_logo" class="logo_button button" type="button" value="Upload/Insert" />
                            <input class="remove_logo button" type="button" data_logo_type="theme_logo" value="Delete Logo">
                            <p class="description">Here you can upload the logo for the theme, or use an image that already exists in the media library</p>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label>Current theme logo</label>
                        </th>
                        <td id="theme_logo_wrapper" class="theme-logo">
                        <?php
                        if(get_option('theme_logo'))
                        {
                            $attachment_id = get_attachment_id_by_guid(get_option('theme_logo'));
                            $attachment_image_array = wp_get_attachment_image_src($attachment_id, 'full');
                            ?>
                            <img src="<?php echo $attachment_image_array[0]; ?>" height="100" alt="site logo" />
                            <?php
                        }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label>Theme Backend Logo</label>
                        </th>
                        <td>
                            <input id="theme_backend_logo" class="button" type="hidden" size="36" name="theme_backend_logo" value="<?php echo get_option('theme_backend_logo'); ?>" />
                            <input id="theme_backend_logo_button" data_text_input="theme_backend_logo" class="logo_button button" type="button" value="Upload/Insert" />
                            <input class="remove_logo button" type="button" data_logo_type="theme_backend_logo" value="Delete Logo">
                            <p class="description">Here you can upload the logo for the backend login screen. If you don't upload one. The standard wordpress logo will be used</p>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label>Current theme backend logo</label>
                        </th>
                        <td id="theme_backend_logo_wrapper" class="theme-logo">
                            <?php
                            if(get_option('theme_backend_logo')) {
                                $attachment_id = get_attachment_id_by_guid(get_option('theme_backend_logo'));
                                $attachment_image_array = wp_get_attachment_image_src($attachment_id, 'full');
                                ?>
                            <img src="<?php echo $attachment_image_array[0]; ?>" height="100" alt="site backend logo" />
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
            </p>
        </form>
    </div>
<?php
}

function analytics_sub_page() {
    if(isset($_POST['submit'])) {
        update_option("theme_analytics", $_POST['theme_analytics']);
    }
    ?>
    <div class="wrap">
        <h2>Analytics Settings</h2>
        <?php
        if(isset($_POST['submit'])) {
            ?>
            <div id="setting-error-settings_updated" class="updated settings-error">
                <p><strong>Theme settings saved.</strong></p>
            </div>
            <?php
        }
        ?>
        <p>Here you can insert your google analytics tracking code</p>
        <form method="post">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th>
                            <label>Tracking code</label>
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <p><textarea rows="15" cols="50" class="large-text code" name="theme_analytics"><?php echo stripslashes(get_option('theme_analytics')); ?></textarea></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
            </p>
        </form>
    </div>
    <?php
}

/**
 * Renders the contact form sub page
 */
function contactform_sub_page() {

    if(isset($_POST['submit'])) {
        // Update options for all fields. Remember to add your option here if you add a field in the form
        update_option("recipient_email", $_POST['recipient_email']);
        update_option("prof_options", $_POST['prof_options']);
        update_option("contact_form_subject", $_POST['contact_form_subject']);
        update_option("form_mail_title", $_POST['form_mail_title']);
        update_option("form_mail_content", $_POST['form_mail_content']);
        update_option("contact_form_confirmation", $_POST['contact_form_confirmation']);
    }

    ?>
    <div class="wrap">
        <h2>Contact Form Settings</h2>
        <?php
        if(isset($_POST['submit'])) {
            ?>
            <div id="setting-error-settings_updated" class="updated settings-error">
                <p><strong>Contact form settings saved.</strong></p>
            </div>
            <?php
        }
        ?>
        <p>Here you can setup your contact form</p>
        <form method="post">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th>
                            <label for="recipient_email">Recipient E-mail</label>
                        </th>
                        <td><p><input type="text" id="recipient_email" name="recipient_email" class="regular-text" value="<?php echo get_option('recipient_email'); ?>" /></p></td>
                    </tr>
                    <tr>
                        <th>
                            <label for="contact_form_subject">Subject</label>
                        </th>
                        <td><p><input type="text" id="contact_form_subject" name="contact_form_subject" class="regular-text" value="<?php echo get_option('contact_form_subject'); ?>" /></p></td>
                    </tr>
                    <tr>
                        <th>
                            <label for="contact_form_confirmation">Confirmation Message</label>
                        </th>
                        <td><p><input type="text" id="contact_form_confirmation" name="contact_form_confirmation" class="regular-text" value="<?php echo get_option('contact_form_confirmation'); ?>" /></p></td>
                    </tr>
                </tbody>
            </table>
            <h3>Fields</h3>
            <p>Settings for specific fields in the contact form</p>
            <table class="form-table">
                <tbody>
                <tr>
                    <th>
                        <label for="prof_options">Proffesion dropdown options. <i class="description">Seperate by breaks (enter)</i></label>
                    </th>
                    <td><p><textarea rows="5" cols="20" class="large-text code" name="prof_options" id="prof_options"><?php echo get_option('prof_options'); ?></textarea></p></td>
                </tr>
                </tbody>
            </table>
            <h3>Email</h3>
            <p>Settings for the mail that will be sent to the recipient</p>
            <table class="form-table">
                <tbody>
                <tr>
                    <th>
                        <label for="form_mail_title">Mail Title</label>
                    </th>
                    <td><p><input type="text" id="form_mail_title" name="form_mail_title" class="regular-text" value="<?php echo get_option('form_mail_title'); ?>" /></p></td>
                </tr>
                <tr>
                    <th>
                        <label for="form_mail_content">Mail Content</label>
                    </th>
                    <td><p><textarea rows="5" cols="20" class="large-text code" name="form_mail_content" id="form_mail_content"><?php echo get_option('form_mail_content'); ?></textarea></p></td>
                </tr>
                </tbody>
            </table>

            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
            </p>
        </form>
    </div>
    <?php
}
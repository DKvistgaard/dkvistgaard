<?php
/**
 *  Install Add-ons
 *  
 *  The following code will include all 4 premium Add-Ons in your theme.
 *  Please do not attempt to include a file which does not exist. This will produce an error.
 *  
 *  All fields must be included during the 'acf/register_fields' action.
 *  Other types of Add-ons (like the options page) can be included outside of this action.
 *  
 *  The following code assumes you have a folder 'add-ons' inside your theme.
 *
 *  IMPORTANT
 *  Add-ons may be included in a premium theme as outlined in the terms and conditions.
 *  However, they are NOT to be included in a premium / free plugin.
 *  For more information, please read http://www.advancedcustomfields.com/terms-conditions/
 */ 

//define( 'ACF_LITE', true );

include_once('advanced-custom-fields/acf.php');

// Fields 
add_action('acf/register_fields', 'register_fields');

/**
 * Register Fields
 *
 * Out and In comment the fields you need for your solution
 */
function register_fields()
{
    // Repeater Field
	include_once('add-ons/acf-repeater/repeater.php');
    // Flexible Content Field
    include_once('add-ons/acf-flexible-content/flexible-content.php');
    // Options Page
    include_once('add-ons/acf-options-page/acf-options-page.php');
}

/**
 *  Register Field Groups
 *
 *  The register_field_group function accepts 1 array which holds the relevant data to register a field group
 *  You may edit the array as you see fit. However, this may result in errors if the array is not compatible with ACF
 */

if(function_exists("register_field_group"))
{
	// Add Field Export here
}

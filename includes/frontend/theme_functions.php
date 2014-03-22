<?php

/**
 * Function that prints the tracking code inserted in the theme settings
 * Strips the slashes that were added when inserting the code to the
 * database
 */
function print_tracking_code()
{
    $tracking_code = get_option('theme_analytics');
    if($tracking_code) {
        echo stripslashes($tracking_code)."\n";
    }
}
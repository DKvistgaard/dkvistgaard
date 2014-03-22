<?php

/**
 * Gets the field select options and explodes the string by newlines
 *
 * Returns a array of cleaned field options.
 *
 * @param string $field_name
 * @return array
 */
function get_contact_form_options($field_name = '')
{
    $fields_string = get_option($field_name);

    // Explode the fields string by newlines
    $field_options_array = explode("\n", $fields_string);
    $return_array = array();

    // Iterate through the array trimming the strings and skipping empty options
    foreach($field_options_array as $field_option){
        $field_option = trim($field_option);
        if(strlen($field_option) > 0){
            $return_array[] = $field_option;
        }
    }
    return $return_array;
}

/**
 * Sends a mail to recipient email entered in contact form settings
 * Containing data from contact form.
 *
 * @param array $post_array
 */
function submit_contact_form($post_array = array()){
    // Set recipient to user entered email, fallback to admin email.
    $recipient = get_option("recipient_email");
    if(!$recipient){
        $recipient = get_bloginfo('admin_email');
    }

    // Get subject from backend, fallback to standard string using blog name.
    $subject = get_option("contact_form_subject");
    if(!$subject){
        $subject = get_bloginfo("name") . ". Contact Form" ;
    }

    // Get form values from post array.
    $name = $post_array['contact_name'];
    $email = $post_array['contact_email'];
    $profession = $post_array['contact_profession'];

    // Set newline to breaks
    $message = nl2br($post_array['contact_text']);

    // Setup mail headers
    $headers= "MIME-Version: 1.0\n" .
        "Content-Type: text/html; " .
        "charset=\"" . get_option('blog_charset') . "\"\n";

    // Setup mail title and content
    $title = (get_option('form_mail_title')) ? get_option('form_mail_title') : "Contact form submission";
    $content = (get_option('form_mail_content')) ? get_option('form_mail_content') : "Your contact form has been submitted";

    // Create mail html
    $mail_body =
        "
        <h2>{$title}</h2>
        <p><i>{$content}</i></p>
        <table>
            <tbody>
                <tr>
                    <td><strong>Name</strong></td>
                    <td>{$name}</td>
                </tr>
                <tr>
                    <td><strong>Email</strong></td>
                    <td>{$email}</td>
                </tr>
                <tr>
                    <td><strong>Option</strong></td>
                    <td>{$profession}</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;'><strong>Message</strong></td>
                    <td>{$message}</td>
                </tr>
            </tbody>
        </table>
        ";

    // Send the mail
    wp_mail($recipient, $subject, $mail_body, $headers);
}

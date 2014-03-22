<?php

$confirmation = null;

// Handle form submission
if(isset($_POST['submit'])){
    submit_contact_form($_POST);
    // Get confirmation message or use default
    $confirmation = (get_option('contact_form_confirmation')) ? get_option('contact_form_confirmation') : "Thank you, we will get back as soon as possible";
}

?>
<?php
/*
 Template Name: Contact Form
 */
?>

<?php get_header(); ?>

<form method="post" action="<?php the_permalink(); ?>">
    <?php
    if($confirmation){
        echo "<p>{$confirmation}</p>";
    }
    ?>
    <input type="text" id="contact_name" name="contact_name" value="" placeholder="name" />
    <input type="text" id="contact_email" name="contact_email" value="" placeholder="email" />
    <textarea id="contact_text" name="contact_text"></textarea>
    <select name="contact_profession">
        <?php
        $profession_options = get_contact_form_options('prof_options');
        foreach($profession_options as $option){
            echo "<option value='" . $option . "'>" . $option . "</option>";
        }
        ?>
    </select>
    <input type="submit" id="submit" name="submit" value="contact" />
</form>

<?php get_footer(); ?>
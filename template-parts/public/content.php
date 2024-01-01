<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Swingster
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php
    while (have_posts()) :
        the_post();

        // Get the selected template
        $selected_template = get_post_meta(get_the_ID(), 'selected_template', true);

        if (!empty($selected_template) && locate_template($selected_template . '.php') !== '') {
            // Load the selected template content
            get_template_part($selected_template);
        } else {
            // Fallback to default content from WordPress editor
            the_content(); // This displays the content added through the WordPress editor
        }

        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;

    endwhile; // End of the loop.
    ?>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();
?>
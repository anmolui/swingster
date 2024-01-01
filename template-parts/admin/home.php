<?php
$theme = wp_get_theme();
$theme_version = $theme->get('Version');
// Handle form submission
if (isset($_POST['submit'])) {
    // Save the checkbox value
    $hide_banner = isset($_POST['sw-main__banner-hide']) ? '1' : '0';
    $banner_title = isset($_POST['sw-main__banner-title']) ? sanitize_text_field($_POST['sw-main__banner-title']) : '';
    update_option('sw-main__banner-hide', $hide_banner);
    update_option('sw-main__banner-title', $banner_title);
}

// Get the current value of the checkbox option
$hide_banner = get_option('sw-main__banner-hide') ? 'checked' : '';
$banner_title = get_option('sw-main__banner-title');
?>

<div class="swh">
    <h2><span>Welcome! to</span> Homepage</h2>
    <header class="sw-header">

    </header>
    <main class="sw-main">
        <section class="sw-main__banner">
            <form method="post" action="">
                <ul class="sw-main__banner-form">
                    <li>
                        <label for="sw-main__banner-hide">Hide Banner</label>
                        <input type="checkbox" id="sw-main__banner-hide" name="sw-main__banner-hide" <?php echo $hide_banner; ?>>
                    </li>
                    <li>
                        <label for="sw-main__banner-title">Banner Title</label>
                        <input type="text" id="sw-main__banner-title" name="sw-main__banner-title" value="<?php echo $banner_title; ?>" />
                    </li>
                </ul>
                <p><input type="submit" name="submit" class="button button-primary" value="Save Changes" /></p>
            </form>
        </section>
    </main>
    <footer class="sw-footer">All Designing and theme settings are working with <span><?php echo $theme_version ?></span></footer>
</div>

<?php

?>
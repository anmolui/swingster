<?php
$theme = wp_get_theme();
$theme_version = $theme->get('Version');
?>

<div class="sw">
    <h2><span>Welcome! </span>to Swingster</h2>
    <header class="sw-header">

    </header>
    <main class="sw-main">
        <section class="sw-main__banner">
            <ul class="sw-main__banner-form">
                <li>
                    <p>Your WordPress theme powerhouse for those who value simplicity, crave knowledge, demand excellence, and seek ease of use. This theme embodies a harmonious blend of sophistication and straightforwardness, designed to offer a seamless and intuitive experience.</p>
                </li>
                <li>
                    <label>License</label>
                    <p>GNU General Public License v2 or later</p>
                </li>
                <li>
                    <label>Requires PHP</label>
                    <p>5.6</p>
                </li>
                <li>
                    <a href="https://wpswings.com/">
                        <label>Website</label>
                    </a>
                </li>
            </ul>
        </section>
    </main>
    <footer class="sw-footer">All Designing and theme settings are working with <span><?php echo $theme_version ?></span></footer>
</div>

<?php

?>
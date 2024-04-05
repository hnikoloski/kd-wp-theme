<footer id="colophon" class="site-footer">
    <div class="site-info">
        <div class="site-info__about">
            <?php if (get_field('footer_description', 'option')) : ?>
                <p><?php echo get_field('footer_description', 'option'); ?></p>
            <?php endif; ?>
            <?php if (get_field('footer_logo', 'option')) : ?>
                <div class="site-info__logo">
                    <img src="<?php echo get_field('footer_logo', 'option')['url']; ?>" alt="<?php echo get_field('footer_logo', 'option')['alt'] ?: get_bloginfo('name'); ?>" class="full-size-img full-size-img-contain">
                </div>
            <?php endif; ?>
        </div>
        <div class="site-footer__useful-links">
            <h3 class="site-footer__label">USEFUL LINKS</h3>
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'useful_links',
                    'menu_class' => 'footer-menu footer-menu--useful-links',
                    'container' => false,
                    'fallback_cb' => false,
                )
            );
            ?>
        </div>

        <div class="site-footer__privacy">
            <h3 class="site-footer__label">PRIVACY POLICY</h3>
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'privacy_policy',
                    'menu_class' => 'footer-menu',
                    'container' => false,
                    'fallback_cb' => false,
                )
            );
            ?>
        </div>
        <div class="site-info__contact">
            <h3 class="site-footer__label">CONTACT INFO</h3>
            <?php if (have_rows('contact_items', 'option')) : ?>
                <ul>
                    <?php
                    while (have_rows('contact_items', 'option')) : the_row();
                        $label = get_sub_field('label');
                        $link = get_sub_field('link');
                        $contact_type = get_sub_field('contact_type');
                        $prefix = '';
                        if ($contact_type === 'email' && $link) {
                            $prefix = 'mailto:';
                        } elseif ($contact_type === 'phone' && $link) {
                            $prefix = 'tel:';
                        }
                    ?>
                        <li>
                            <?php if ($label) : ?>
                                <span class="site-info__contact__label"><?= $label; ?></span>
                            <?php endif; ?>
                            <?php if ($link) : ?>
                                <a href="<?= $prefix . $link; ?>" class="site-info__contact__link"><?= $link; ?></a>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php
            endif; ?>
        </div>
    </div><!-- .site-info -->
    <div class="site-footer__copy-bar">
        <div class="site-footer__copy-bar__wrapper">
            <div class="site-footer__copy-bar__content">
                <p>Copyright <span class="color-red">©</span> 2024 Kristina Damil. All rights reserved.</p>
                <?php
                if (have_rows('social_media', 'option')) : ?>
                    <ul class="social-media">
                        <?php
                        while (have_rows('social_media', 'option')) : the_row();
                            $icon = get_sub_field('icon');
                            $link = get_sub_field('link');
                        ?>
                            <li class="social-media__item">
                                <a href="<?= $link; ?>" target="_blank" rel="noopener noreferrer">
                                    <img src="<?= $icon['url']; ?>" alt="<?= $icon['alt']; ?>">
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif;
                ?>

            </div>
        </div>
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>
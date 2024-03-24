<footer id="colophon" class="site-footer">
    <div class="site-info">

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
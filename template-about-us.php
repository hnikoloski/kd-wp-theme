<?php
// Template Name: About Us Page

get_header(); ?>


<div class="about-us-page">
    <div class="about-us-page__hero">
        <h1 class="about-us-page__hero__title"><?php the_title(); ?></h1>
    </div>
    <div class="about-us-page__content">
        <?php
        if (have_rows('about_us_sections')) :
            while (have_rows('about_us_sections')) : the_row();
                $title = get_sub_field('title');
                $description = get_sub_field('description');
                $image = get_sub_field('image');
                $smaller_image = get_sub_field('smaller_image');
        ?>
                <div class="about-us-page__content__section">
                    <div class="about-us-page__content__section__image">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($title); ?>" class="full-size-img full-size-img-cover">
                    </div>
                    <div class="about-us-page__content__section__text">
                        <h2 class="about-us-page__content__section__text__title"><?php echo esc_html($title); ?></h2>
                        <div class="about-us-page__content__section__text__description"><?php echo $description; ?></div>
                        <?php if ($smaller_image) : ?>
                            <div class="about-us-page__content__section__smaller-image">
                                <img src="<?php echo esc_url($smaller_image['url']); ?>" alt="<?php echo esc_attr($title); ?>" class="full-size-img full-size-img-cover d-block">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>
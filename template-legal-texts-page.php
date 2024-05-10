<?php
// Template Name: Legal Texts Template

get_header(); ?>


<div class="legal-texts-page">
    <div class="legal-texts-page__hero">
        <h1 class="legal-texts-page__hero__title"><?php the_title(); ?></h1>
    </div>
    <div class="legal-texts-page__content">
        <?php the_content(); ?>
    </div>
</div>
<?php get_footer(); ?>
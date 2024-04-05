<?php
$first_line = get_field('first_line', 'option');
$first_line_color = get_field('first_line_color', 'option');
$first_line_size = get_field('first_line_size', 'option');

$second_line = get_field('second_line', 'option');
$second_line_color = get_field('second_line_color', 'option');
$second_line_size = get_field('second_line_size', 'option');

$third_line = get_field('third_line', 'option');
$third_line_color = get_field('third_line_color', 'option');
$third_line_size = get_field('third_line_size', 'option');

$image = get_field('image', 'option');
?>

<div id="promotional-banner" class="promotional-banner">

    <div class="promotional-banner__content" style="--bg-img:url('<?= $image['url']; ?>');">
        <button class="promotional-banner__content__close-button" aria-label="Close promotional banner">
        </button>
        <div class="promotional-banner__content__wrapper">
            <?php if ($first_line) : ?>
                <p class="promotional-banner__content__first-line size-<?= $first_line_size; ?>" style="--color:<?= $first_line_color; ?>;"><?= $first_line; ?></p>
            <?php endif; ?>
            <?php if ($second_line) : ?>
                <p class="promotional-banner__content__second-line size-<?= $second_line_size; ?>" style="--color:<?= $second_line_color; ?>;"><?= $second_line; ?></p>
            <?php endif; ?>
            <?php if ($third_line) : ?>
                <p class="promotional-banner__content__third-line size-<?= $third_line_size; ?>" style="--color:<?= $third_line_color; ?>;"><?= $third_line; ?></p>
            <?php endif; ?>
        </div>

        <?php if (get_field('button', 'option')) : ?>
            <a href="<?= get_field('button', 'option')['url']; ?>" class="promotional-banner__content__button button button--primary"><?= get_field('button', 'option')['title']; ?></a>
        <?php endif; ?>

    </div>

</div>
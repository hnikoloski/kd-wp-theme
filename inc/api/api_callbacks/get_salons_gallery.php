<?php
function get_salons_gallery($request)
{
    $salon_id = $request['salon_id'];
    $result = array();

    $args = array(
        'post_type' => 'salon',
        'posts_per_page' => -1,  // Retrieve all posts
        'orderby' => 'title',
        'order' => 'ASC',
        'post_status' => 'publish'
    );

    // Filter by specific salon ID if provided
    if ($salon_id) {
        $args['p'] = $salon_id;
    }

    $salons = get_posts($args);
    foreach ($salons as $salon) {
        $salon_gallery = get_field('gallery', $salon->ID);
        $gallery_images = array();
        if ($salon_gallery) {
            $counter = 0;
            foreach ($salon_gallery as $image) {
                $counter++;
                $fallback_alt = $salon->post_title . ' Gallery Image ' . $counter;
                $gallery_images[] = array(
                    'url' => $image['url'],
                    'alt' => $image['alt'] ? $image['alt'] : $fallback_alt
                );
            }
        }
        if (!empty($gallery_images)) {
            $result[] = array(
                'id' => $salon->ID,
                'gallery' => $gallery_images
            );
        }
    }

    // Merge all galleries into one array 
    $merged_galleries = array();
    foreach ($result as $salon_gallery) {
        $merged_galleries = array_merge($merged_galleries, $salon_gallery['gallery']);
    }



    return $merged_galleries;
}

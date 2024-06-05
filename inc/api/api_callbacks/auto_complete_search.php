<?php
function auto_complete_search($request)
{
    global $wpdb; // Global WordPress database class

    $post_type = $request->get_param('post_type');
    $search_term = $wpdb->esc_like($request->get_param('search_term')) . '%'; // Ensure the search term matches the start of the title

    // Direct SQL query to get posts
    $sql = $wpdb->prepare("
        SELECT * FROM {$wpdb->posts}
        WHERE post_status = 'publish'
        AND post_type = %s
        AND post_title LIKE %s
        ORDER BY post_title ASC
        LIMIT 6
    ", $post_type, $search_term);

    $posts = $wpdb->get_results($sql);

    $results = array();
    foreach ($posts as $post) {
        $post_id = $post->ID;
        $post_title = get_the_title($post_id);
        $post_permalink = get_permalink($post_id);
        $post_image = get_the_post_thumbnail_url($post_id, 'full');

        $results[] = array(
            'id' => $post_id,
            'title' => $post_title,
            'permalink' => $post_permalink,
            'image' => $post_image,
        );
    }

    return $results;
}

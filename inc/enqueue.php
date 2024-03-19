<?php

/**
 * Enqueue scripts and styles.
 */
function tamtam_enqueue_assets()
{
    $theme_version = wp_get_theme()->get('Version');
    $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
    wp_enqueue_script('jquery');
    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), true);

        // Loop through the manifest to find and enqueue all relevant scripts and styles
        foreach ($manifest as $key => $value) {
            // Check if the asset is a block asset
            if (strpos($key, 'src/blocks-assets/scripts/') === 0) {
                $file = $value['file'];
                $css = isset($value['css']) ? $value['css'] : [];

                // Enqueue the JS file
                $handle = 'tamtam-block-' . pathinfo($key, PATHINFO_FILENAME);
                wp_enqueue_script($handle, get_template_directory_uri() . "/dist/$file", array(), $theme_version, true);


                // Enqueue any CSS files associated with this block
                foreach ($css as $cssFile) {
                    wp_enqueue_style($handle . '-css', get_template_directory_uri() . "/dist/$cssFile", array(), $theme_version);
                }
            }
        }

        // Optionally, you can still manually enqueue other specific files as needed
        // For example, the main app script and global style
        if (isset($manifest['src/app.js'])) {
            $app_js = $manifest['src/app.js']['file'];
            wp_enqueue_script('tamtam-app', get_template_directory_uri() . "/dist/$app_js", array(), $theme_version, true);
        }

        if (isset($manifest['src/app.scss'])) {
            $global_style_css = $manifest['src/app.scss']['file'];
            wp_enqueue_style('tamtam-global-style', get_template_directory_uri() . "/dist/$global_style_css", array(), $theme_version);
        }
    } else {
        // Manifest file not found - handle error or fallback
    }
}

// Add module to the js files that start with tamtam-
function tamtam_add_module($tag, $handle, $src)
{
    if (strpos($handle, 'tamtam-block-') === 0) {
        $tag = '<script type="module" src="' . esc_url($src) . '" id="' . $handle . '-module"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'tamtam_add_module', 10, 3);

add_action('wp_enqueue_scripts', 'tamtam_enqueue_assets');

<?php
// https://dev.to/ninjasoards/easy-headless-wordpress-with-nuxt-netlify-5c4a
// add ACF object to default posts endpoint
add_filter('rest_prepare_post', 'acf_to_rest_api', 10, 3);
// adds ACF object to wwa_artwork endpoint
add_filter('rest_prepare_wwa_artwork', 'acf_to_rest_api', 10, 3);
function acf_to_rest_api($response, $post, $request)
{
    if (!function_exists('get_fields')) {
        return $response;
    }

    if (isset($post)) {
        $acf = get_fields($post->id);
        $response->data['acf'] = $acf;
    }
    return $response;
}

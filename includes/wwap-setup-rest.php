<?php

class Wwap_Custom_Route extends WP_REST_Controller {
    public function register_routes() {
        $version = '1';
        $namespace = 'wwap/v' . $version;
        $base = 'artwork';
        register_rest_route( $namespace, '/' . $base, array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array( $this, 'get_items' ),
            ),
            'schema' => array( $this, 'get_item_schema' ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/recent', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array( $this, 'get_recent_items' ),
            ),
            'schema' => array( $this, 'get_item_schema' ),
        ) );
    }

    public function get_items( $request ) {
       $args = array(
           'posts_per_page' => 5,
           'post_type' => 'wwa_artwork',
       );
       $posts = get_posts( $args );

       $data = array();

       if ( empty( $posts ) ) {
           return rest_ensure_response( $data );
       }

       foreach ( $posts as $post ) {
           $response = $this->prepare_item_for_response( $post, $request );
           $data[] = $this->prepare_response_for_collection( $response );
       }

       return rest_ensure_response( $data );
    }

    public function get_recent_items( $request ) {
       $args = array(
           'posts_per_page' => -1,
           'post_type' => 'wwa_artwork',
           'tag' => 'recent'
       );
       $posts = get_posts( $args );

       $data = array();

       if ( empty( $posts ) ) {
           return rest_ensure_response( $data );
       }

       foreach ( $posts as $post ) {
           $response = $this->prepare_item_for_response( $post, $request );
           $data[] = $this->prepare_response_for_collection( $response );
       }

       return rest_ensure_response( $data );
    }

    public function prepare_item_for_response( $post, $request ) {
        
        $post_data = array();

        $schema = $this->get_item_schema( $request );

        $img_srcset = wp_get_attachment_image_srcset( $post->image, 'full' );
        
        $img_src = wp_get_attachment_image_src( $post->image, 'full' );

        if ( isset( $schema['properties']['id'] ) ) {
            $post_data['id'] = (int) $post->ID;
        }

        if ( isset( $schema['properties']['acf_title'] ) ) {
            array(
               $post_data['title'] = $post->title, 
            );     
        }
        if ( isset( $schema['properties']['acf_medium'] ) ) {
            array(
               $post_data['medium'] = $post->medium, 
            );     
        }
        if ( isset( $schema['properties']['acf_dimensions'] ) ) {
            array(
               $post_data['dimensions'] = $post->dimensions, 
            );     
        }
        if ( isset( $schema['properties']['acf_date'] ) ) {
            array(
               $post_data['date'] = $post->date, 
            );     
        }
        if ( isset( $schema['properties']['acf_image'] ) ) {
            array(
                $post_data['image']['srcset'] = $img_srcset,
                $post_data['image']['src'] = $img_src[0],
            );
        }
        if ( isset( $schema['properties']['tags'] ) ) {
            $post_data['tags'] = get_the_tags( $post );
        }

        return rest_ensure_response( $post_data );
    }

    public function prepare_response_for_collection( $response ) {
        if ( ! ( $response instanceof WP_REST_Response ) ) {
            return $response;
        }

        $data = (array) $response->get_data();
        $server = rest_get_server();

        if ( method_exists( $server, 'get_compact_response_links' ) ) {
            $links = call_user_func( array( $server, 'get_compact_response_links' ), $response );
        } else {
            $links = call_user_func( array( $server, 'get_response_links' ), $response );
        }

        if ( ! empty( $links ) ) {
            $data['_links'] = $links;
        }

        return $data;
    }

    public function get_item_schema() {
        if ( $this->schema ) {
            return $this->schema;
        }

        $this->schema = array(
            '$schema' => 'http://json-schema.org/draft-04/schema#',
            'title' => 'post',
            'type' => 'object',
            'properties' => array(
                'id' => array(
                    'description' => esc_html__( 'Unique identifier for the object.', 'my-textdomain' ),
                    'type' => 'integer',
                    'context' => array( 'view', 'edit', 'embed' ),
                    'readonly' => true,
                ),
                'acf_title' => array(
                    'description' => esc_html__( 'Custom field from ACF for the object title.', 'my-textdomain' ),
                    'type' => 'string',
                    'context' => array( 'view', 'edit', 'embed' ),
                    'readonly' => true,
                ),
                'acf_medium' => array(
                    'description' => esc_html__( 'Custom field from ACF for the object medium.', 'my-textdomain' ),
                    'type' => 'string',
                    'context' => array( 'view', 'edit', 'embed' ),
                    'readonly' => true,
                ),
                'acf_dimensions' => array(
                    'description' => esc_html__( 'Custom field from ACF for the object dimensions.', 'my-textdomain' ),
                    'type' => 'string',
                    'context' => array( 'view', 'edit', 'embed' ),
                    'readonly' => true,
                ),
                'acf_date' => array(
                    'description' => esc_html__( 'Custom field from ACF for the object date.', 'my-textdomain' ),
                    'type' => 'string',
                    'context' => array( 'view', 'edit', 'embed' ),
                    'readonly' => true,
                ),
                'acf_image' => array(
                    'description' => esc_html__( 'Custom field from ACF for the object image.', 'my-textdomain' ),
                    'type' => 'string',
                    'context' => array( 'view', 'edit', 'embed' ),
                    'readonly' => true,
                ),
                'tags' => array(
                    'description' => esc_html__( 'Tags for the object image.', 'my-textdomain' ),
                    'type' => 'integer',
                ),
            ),
        );

        return $this->schema;
    }
}// end class definition

function wwap_register_my_rest_routes() {
    $controller = new Wwap_Custom_Route();
    $controller->register_routes();
}

add_action( 'rest_api_init', 'wwap_register_my_rest_routes' );

   add_filter( 'rest_prepare_wwa_artwork', function( $response, $post, $request ) {
        if ( !function_exists( 'get_fields' ) ) return $response;

        if ( isset( $post ) ) {
            $acf = get_fields( $post->id );
            $response->data['acf'] = $acf; 
        }

        return $response;
    }, 10, 3 );

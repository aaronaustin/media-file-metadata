<?php
/*Plugin Name: Add Metadata to Media File in API
Description: This plugin adds metadata to media files.
Version: 1.0
License: GPLv2
GitHub Plugin URI: https://github.com/aaronaustin/media-file-metadata
*/

require_once( ABSPATH . 'wp-admin/includes/media.php' );

//add custom Meta to API endpoint
//https://developer.wordpress.org/reference/functions/register_rest_field/
add_action( 'rest_api_init', 'create_media_file_meta_field' );

function create_media_file_meta_field() {
    // register_rest_field ( 'name-of-post-type', 'name-of-field-to-return', array-of-callbacks-and-schema() )
    register_rest_field( 'post', 'audio_length', array(
           'get_callback'    => 'get_media_meta_length_for_api',
           'schema'          => null,
        )
    );
}

function get_media_meta_length_for_api($field ) {
    $audio_file = get_field('audio_file'); 
    $audio_file_path = get_attached_file($audio_file['id']);
    $metadata = wp_read_audio_metadata($audio_file_path);
    $audio_metadata = $metadata['length'];
    return $audio_metadata;
}

?>

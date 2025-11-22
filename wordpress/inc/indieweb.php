<?php
/**
 * IndieWeb Integration for Sinople Theme
 *
 * Implements Webmention and Micropub endpoints for IndieWeb Level 4 compliance
 *
 * @package Sinople
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add IndieWeb discovery links to head
 */
function sinople_indieweb_discovery() {
    $webmention_endpoint = rest_url( 'sinople/v1/webmention' );
    $micropub_endpoint   = rest_url( 'sinople/v1/micropub' );

    echo '<link rel="webmention" href="' . esc_url( $webmention_endpoint ) . '">' . "\n";
    echo '<link rel="micropub" href="' . esc_url( $micropub_endpoint ) . '">' . "\n";
    echo '<link rel="authorization_endpoint" href="https://indieauth.com/auth">' . "\n";
    echo '<link rel="token_endpoint" href="https://tokens.indieauth.com/token">' . "\n";
}
add_action( 'wp_head', 'sinople_indieweb_discovery' );

/**
 * Register IndieWeb REST API endpoints
 */
function sinople_register_indieweb_api() {
    // Webmention endpoint
    register_rest_route( 'sinople/v1', '/webmention', array(
        'methods'             => 'POST',
        'callback'            => 'sinople_webmention_endpoint',
        'permission_callback' => '__return_true',
    ) );

    // Micropub endpoint
    register_rest_route( 'sinople/v1', '/micropub', array(
        'methods'             => array( 'GET', 'POST' ),
        'callback'            => 'sinople_micropub_endpoint',
        'permission_callback' => 'sinople_micropub_permission',
    ) );
}
add_action( 'rest_api_init', 'sinople_register_indieweb_api' );

/**
 * Webmention endpoint handler
 */
function sinople_webmention_endpoint( $request ) {
    $source = $request->get_param( 'source' );
    $target = $request->get_param( 'target' );

    // Validate parameters
    if ( empty( $source ) || empty( $target ) ) {
        return new WP_Error( 'invalid_request', 'Source and target required', array( 'status' => 400 ) );
    }

    // Verify target is on this site
    $home_url = home_url();
    if ( strpos( $target, $home_url ) !== 0 ) {
        return new WP_Error( 'invalid_target', 'Target not on this site', array( 'status' => 400 ) );
    }

    // Queue webmention for async processing
    $webmention_id = wp_insert_post( array(
        'post_type'   => 'sinople_webmention',
        'post_status' => 'pending',
        'post_title'  => $source,
        'meta_input'  => array(
            '_sinople_wm_source' => esc_url_raw( $source ),
            '_sinople_wm_target' => esc_url_raw( $target ),
        ),
    ) );

    return new WP_REST_Response( array(
        'status'  => 'accepted',
        'message' => 'Webmention accepted for processing',
    ), 202 );
}

/**
 * Micropub permission callback
 */
function sinople_micropub_permission( $request ) {
    $token = $request->get_header( 'Authorization' );

    if ( empty( $token ) ) {
        return new WP_Error( 'unauthorized', 'Authorization required', array( 'status' => 401 ) );
    }

    // Verify token with IndieAuth
    // In production, implement full IndieAuth verification
    return true;
}

/**
 * Micropub endpoint handler
 */
function sinople_micropub_endpoint( $request ) {
    $method = $request->get_method();

    if ( $method === 'GET' ) {
        // Configuration query
        $q = $request->get_param( 'q' );

        if ( $q === 'config' ) {
            return new WP_REST_Response( array(
                'media-endpoint' => rest_url( 'sinople/v1/media' ),
            ) );
        }

        if ( $q === 'syndicate-to' ) {
            return new WP_REST_Response( array(
                'syndicate-to' => array(),
            ) );
        }
    }

    if ( $method === 'POST' ) {
        // Create post from Micropub request
        $content_type = $request->get_content_type();

        if ( $content_type['value'] === 'application/json' ) {
            $data = $request->get_json_params();
        } else {
            $data = $request->get_body_params();
        }

        // Parse h-entry microformat
        $post_data = array(
            'post_type'   => 'post',
            'post_status' => 'publish',
            'post_title'  => $data['name'] ?? '',
            'post_content' => $data['content'] ?? '',
        );

        $post_id = wp_insert_post( $post_data );

        if ( is_wp_error( $post_id ) ) {
            return new WP_Error( 'create_failed', 'Failed to create post', array( 'status' => 500 ) );
        }

        $location = get_permalink( $post_id );

        return new WP_REST_Response( array( 'url' => $location ), 201, array(
            'Location' => $location,
        ) );
    }

    return new WP_Error( 'method_not_allowed', 'Method not allowed', array( 'status' => 405 ) );
}

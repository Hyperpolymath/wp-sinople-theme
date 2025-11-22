<?php
/**
 * Semantic Web Integration for Sinople Theme
 *
 * Handles RDF/OWL processing, semantic graph generation,
 * and REST API endpoints for semantic data.
 *
 * @package Sinople
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register REST API endpoints for semantic data
 */
function sinople_register_semantic_api() {
    // Semantic graph endpoint
    register_rest_route( 'sinople/v1', '/semantic-graph', array(
        'methods'             => 'GET',
        'callback'            => 'sinople_get_semantic_graph',
        'permission_callback' => '__return_true',
    ) );

    // Construct RDF endpoint
    register_rest_route( 'sinople/v1', '/constructs/(?P<id>\d+)/rdf', array(
        'methods'             => 'GET',
        'callback'            => 'sinople_get_construct_rdf',
        'permission_callback' => '__return_true',
        'args'                => array(
            'id' => array(
                'validate_callback' => function( $param ) {
                    return is_numeric( $param );
                },
            ),
        ),
    ) );

    // Full ontology export
    register_rest_route( 'sinople/v1', '/ontology', array(
        'methods'             => 'GET',
        'callback'            => 'sinople_export_ontology',
        'permission_callback' => '__return_true',
    ) );
}
add_action( 'rest_api_init', 'sinople_register_semantic_api' );

/**
 * Get semantic graph data for visualization
 */
function sinople_get_semantic_graph( $request ) {
    $constructs = get_posts( array(
        'post_type'      => 'sinople_construct',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ) );

    $entanglements = get_posts( array(
        'post_type'      => 'sinople_entanglement',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ) );

    $nodes = array();
    $edges = array();

    // Build nodes
    foreach ( $constructs as $construct ) {
        $nodes[] = array(
            'id'    => $construct->ID,
            'label' => $construct->post_title,
            'type'  => 'construct',
            'iri'   => get_post_meta( $construct->ID, '_sinople_rdf_iri', true ),
        );
    }

    // Build edges
    foreach ( $entanglements as $entanglement ) {
        $source = get_post_meta( $entanglement->ID, '_sinople_source', true );
        $target = get_post_meta( $entanglement->ID, '_sinople_target', true );
        $type   = get_post_meta( $entanglement->ID, '_sinople_relationship_type', true );

        if ( $source && $target ) {
            $edges[] = array(
                'source' => intval( $source ),
                'target' => intval( $target ),
                'label'  => $type ?: 'related',
                'id'     => $entanglement->ID,
            );
        }
    }

    return new WP_REST_Response( array(
        'nodes' => $nodes,
        'edges' => $edges,
    ), 200 );
}

/**
 * Get RDF representation of a construct
 */
function sinople_get_construct_rdf( $request ) {
    $post_id = $request['id'];
    $post    = get_post( $post_id );

    if ( ! $post || $post->post_type !== 'sinople_construct' ) {
        return new WP_Error( 'not_found', 'Construct not found', array( 'status' => 404 ) );
    }

    $iri   = get_post_meta( $post_id, '_sinople_rdf_iri', true ) ?: home_url( "/constructs/{$post->post_name}" );
    $gloss = get_post_meta( $post_id, '_sinople_gloss', true );
    $type  = get_post_meta( $post_id, '_sinople_construct_type', true );

    // Build Turtle format RDF
    $ttl = "@prefix sn: <http://sinople.org/ontology#> .\n";
    $ttl .= "@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .\n";
    $ttl .= "@prefix dc: <http://purl.org/dc/elements/1.1/> .\n\n";

    $ttl .= "<{$iri}> a sn:Construct ;\n";
    $ttl .= "    rdfs:label \"" . addslashes( $post->post_title ) . "\"@en ;\n";

    if ( $post->post_excerpt ) {
        $ttl .= "    rdfs:comment \"" . addslashes( $post->post_excerpt ) . "\"@en ;\n";
    }

    if ( $gloss ) {
        $ttl .= "    sn:hasGloss \"" . addslashes( $gloss ) . "\"@en ;\n";
    }

    if ( $type ) {
        $ttl .= "    sn:constructType \"{$type}\" ;\n";
    }

    $ttl .= "    dc:identifier <{$iri}> .\n";

    return new WP_REST_Response( $ttl, 200, array(
        'Content-Type' => 'text/turtle; charset=UTF-8',
    ) );
}

/**
 * Export full ontology in Turtle format
 */
function sinople_export_ontology( $request ) {
    $ttl = "@prefix sn: <http://sinople.org/ontology#> .\n";
    $ttl .= "@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .\n";
    $ttl .= "@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .\n";
    $ttl .= "@prefix dc: <http://purl.org/dc/elements/1.1/> .\n";
    $ttl .= "@prefix owl: <http://www.w3.org/2002/07/owl#> .\n\n";

    // Export constructs
    $constructs = get_posts( array(
        'post_type'      => 'sinople_construct',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ) );

    foreach ( $constructs as $construct ) {
        $iri = get_post_meta( $construct->ID, '_sinople_rdf_iri', true ) ?: home_url( "/constructs/{$construct->post_name}" );
        $ttl .= "<{$iri}> a sn:Construct ;\n";
        $ttl .= "    rdfs:label \"" . addslashes( $construct->post_title ) . "\"@en .\n\n";
    }

    return new WP_REST_Response( $ttl, 200, array(
        'Content-Type' => 'text/turtle; charset=UTF-8',
    ) );
}

/**
 * Add RDF link to construct head
 */
function sinople_add_rdf_link() {
    if ( is_singular( 'sinople_construct' ) ) {
        $post_id = get_the_ID();
        $api_url = rest_url( "sinople/v1/constructs/{$post_id}/rdf" );
        echo '<link rel="alternate" type="text/turtle" href="' . esc_url( $api_url ) . '" title="RDF Representation">' . "\n";
    }
}
add_action( 'wp_head', 'sinople_add_rdf_link' );

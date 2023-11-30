<?php
/*
Plugin Name: healthcheck
Description: REST API used for site healthcheck
Author: Tengr.ai
Version: 1.0.0
*/
function register_healthcheck()
{
    register_rest_route('api/v1', '/healthcheck/', array(
        'methods' => 'GET',
        'callback' => 'get_healthcheck',
    ));
}

add_action('rest_api_init', 'register_healthcheck');

function get_healthcheck()
{

    $version = wp_get_theme()->get('Version');
    $app_name = get_bloginfo();


    $data = array(
        'appname' => $app_name,
        'version' => $version
    );


    header('Content-Type: application/json');

    return rest_ensure_response($data);
}

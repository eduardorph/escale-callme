<?php
defined( 'ABSPATH' ) or die();
/*
* Plugin name: Escale Callme
* Description: Plugin para integrar ao callback da Claro
* Version: 2.0
* Author: Eduardo - Proteína Digital
*/
define('ESCALE_CALLME_PLUGIN_FILE_URL', __FILE__);

require dirname(__FILE__).'/modulos/settings.php';

$options = get_option( 'ecc_settings' );

if (!empty($options["callme_api_url"]) && !empty($options["callme_api_key"]) && !empty($options["api_mediaId"]) && !empty($options["api_channel"])) {

    require dirname(__FILE__).'/ativacao.php';
    require dirname(__FILE__).'/lib/curl-php/NewCurl.php';
    require dirname(__FILE__).'/Api.php';
    require dirname(__FILE__).'/modulos/modal.php';
    require dirname(__FILE__).'/modulos/form.php';

    // ESTILOS
    function escale_callme_load_jquery() {
        if ( !wp_script_is( 'jquery', 'enqueued' )) {

            //Enqueue
            wp_enqueue_script( 'jquery' );
        }

        wp_register_style( 'escale_callme', plugins_url('/css/escale_callme.css', __FILE__), false, '1.0.5', 'all');
        wp_enqueue_style( 'escale_callme' );

        wp_register_script( 'escale_callme_mask', plugins_url('/lib/mask/jquery.mask.min.js',__FILE__ ), false, '1.0.0', 'all');
        wp_enqueue_script('escale_callme_mask');

        wp_register_script( 'escale_callme', plugins_url('/js/escale_callme.js',__FILE__ ), false, '1.0.12', 'all');
        wp_enqueue_script('escale_callme');

        wp_localize_script('escale_callme', 'ajax_object_callme', array('ajax_url_callme' => admin_url('admin-ajax.php'), 'outro_valor' => 102025, 'ajax_nonce' => wp_create_nonce('escale_callme_3546245624')));
    }
    add_action( 'wp_enqueue_scripts', 'escale_callme_load_jquery' );

}
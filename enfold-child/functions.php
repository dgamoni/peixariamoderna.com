<?php

/*
* Add your own functions here. You can also copy some of the theme functions into this file. 
* Wordpress will use those functions instead of the original functions then.
*/

add_filter( 'avf_google_content_font', 'avia_add_content_font');
function avia_add_content_font($fonts)
{
$fonts['Raleway'] = 'Raleway:400,700';
return $fonts;
}


//set builder mode to debug
add_action('avia_builder_mode', "builder_set_debug");
function builder_set_debug()
{
	return "debug";
}


// Retirar compressão WP das novas fotos a carregar
add_filter('jpeg_quality', function($arg){return 100;});


// Desligar função embed e respectivo js
function speed_stop_loading_wp_embed() {
if (!is_admin()) {
wp_deregister_script('wp-embed');
}
}
add_action('init', 'speed_stop_loading_wp_embed');


// Desligar query de versão WP
function _remove_script_version( $src ){
$parts = explode( '?ver', $src );
return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );


// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Modificar texto default de erro nas reservas

add_filter( 'gform_validation_message_1', 'change_message_1', 10, 2 ); 
function change_message_1( $message, $form ) { 
    return "<div class='validation_error'>" . __( 'Pedimos por favor que preencha os campos em destaque para que possamos dar seguimento seu pedido de reserva.', 'seame' ) . "</div>"; 
} 
add_filter( 'gform_validation_message_2', 'change_message_2', 10, 2 ); 
function change_message_2( $message, $form ) { 
    return "<div class='validation_error'>" . __( 'Por favor preencha todos os campos destacados para que possamos concluir o seu processo de candidatura. Obrigada.', 'seame' ) . "</div>"; 
} 


// Trancar campo de data (torna read only) nas reservas via css
// update '1' to the ID of your form
add_filter('gform_pre_render_1', 'add_readonly_script');
function add_readonly_script($form){
?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        /* apply only to a input with a class of gf_readonly */
        jQuery("li.gf_readonly input").attr("readonly","readonly");
    });
</script>

<?php
return $form;
}




//
// ENFOLD
//

// Inactivar Layerslider
add_theme_support('deactivate_layerslider');

// Inactivar Portfolio
add_action('after_setup_theme', 'remove_portfolio');
function remove_portfolio() {
remove_action('init', 'portfolio_register');
}

// Define email de envio default
function change_cf_from() {
    return "geral@peixariamoderna.com";
}
add_filter('avf_form_from', 'change_cf_from', 10);

// Activar Custom CSS
add_theme_support('avia_template_builder_custom_css');

// Remover bandeiras wpml top bar
function avia_remove_main_menu_flags(){
        remove_filter( 'wp_nav_menu_items', 'avia_append_lang_flags', 9998, 2 );
        remove_filter( 'avf_fallback_menu_items', 'avia_append_lang_flags', 9998, 2 );
        remove_action( 'avia_meta_header', 'avia_wpml_language_switch', 10);
}
add_action('after_setup_theme','avia_remove_main_menu_flags');


<?php
 /*
plugin Name: Custom Color Picker on Setting Page by DreamKoder
plugin URL:http://www.idiotechie.com/downlode/
Description: Some time you need admin to give ability to select color for navigation, body or some other element. So just select color on setting page and use [dk-setting-color] 
Author: DreamKoder
version:0.8
Author URL:http://dreamkoder.com
*/


add_action('admin_init', 'DK_general_section'); 
function DK_general_section() {  
    
    add_settings_section
	(  
        'DK_settings_section',  // Section ID 
        'Custom Color Section ',    // Section Title
        'DK_section_options_callback',  // Callback
        'general'          // What Page?  This makes the section show up on the General Settings Page
    );

    add_settings_field
    (              
        'option_1',    // Option ID
        'Custom Color',    // Label
        'DK_textbox_callback',  // !important - This is where the args go!
        'general',              // Page it will be displayed (General Settings)
        'DK_settings_section', // Name of our section
        array(                   // The $args
            'option_1'     // Should match Option ID
        )  
    ); 
    
    register_setting('general','option_1', 'esc_attr');

}

function DK_section_options_callback() { 
    //so somethign on callback
}


add_action( 'admin_enqueue_scripts', 'DK_enqueue_color_picker' );

function DK_enqueue_color_picker( $hook_suffix ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'DK-custom-color-script', plugins_url('dk-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

function DK_textbox_callback($args) 
 {  
    $option = get_option($args[0]);
    echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" class="dk-color-field"  value="' . $option . '" />';    
	echo '<p>use [dk-setting-color] in visual editors or do_shortcode("[dk-setting-color]") in PHP files.</p>';
 } 


function DK_shortcode()
 {
    ob_start();
    
    mw_enqueue_color_picker( $hook_suffix );
    $value = get_option( 'option_1');
    
    echo $value;
    
    return ob_get_clean();
 }

 add_shortcode('dk-setting-color','DK_shortcode');


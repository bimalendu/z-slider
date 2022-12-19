<?php
if( ! function_exists( 'zslider_get_placeholder_image' )){
    function zslider_get_placeholder_image(){
        return "<img src='" . ZSLIDER_URL . "assets/images/default.jpg' class='img-fluid wp-post-image' />";
    }
}

if( ! function_exists( 'zslider_options' )){
    function zslider_options(){
        $show_bullets = isset( ZSlider_Settings::$options['zslider_bullets'] ) && ZSlider_Settings::$options['zslider_bullets'] == 1 ? true : false;

        wp_enqueue_script( 'zslider-options-js', ZSLIDER_URL . 'vendor/flexslider/flexslider.js', array( 'jquery' ), ZSLIDER_VERSION, true );
        wp_localize_script( 'zslider-options-js', 'SLIDER_OPTIONS', array(
            'controlNav' => $show_bullets
        ) );
    }
}

<?php

/**
 * Plugin Name: ZSlider
 * Plugin URI: https://www.wordpress.org/zslider
 * Description: Easy to use slider
 * Version: 1.0
 * Requires at least: 5.6
 * Author: Bimalendu Behera
 * Author URI: https://forkics.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: zslider
 * Domain Path: /languages
 */

 /*
Z-Slider is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

ZSlider is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with ZSlider. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if( ! defined( 'ABSPATH') ){
    exit;
}

if( ! class_exists( 'ZSlider' ) ){
    class ZSlider{
        function __construct(){
            $this->define_constants();

            $this->load_textdomain();

            require_once( ZSLIDER_PATH . 'functions/functions.php' );

            add_action( 'admin_menu', array( $this, 'add_menu' ) );

            require_once( ZSLIDER_PATH . 'post-types/class.zslider-cpt.php' );
            $ZSlider_Post_Type = new ZSlider_Post_Type();

            require_once( ZSLIDER_PATH . 'class.zslider-settings.php' );
            $ZSlider_Settings = new ZSlider_Settings();

            require_once( ZSLIDER_PATH . 'shortcodes/class.zslider-shortcode.php' );
            $ZSlider_Shortcode = new ZSlider_Shortcode();

            add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 999 );
            add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts') );
        }

        public function define_constants(){
            define( 'ZSLIDER_PATH', plugin_dir_path( __FILE__ ) );
            define( 'ZSLIDER_URL', plugin_dir_url( __FILE__ ) );
            define( 'ZSLIDER_VERSION', '1.0.0' );
        }

        public static function activate(){
            update_option( 'rewrite_rules', '' );
        }

        public static function deactivate(){
            flush_rewrite_rules();
            unregister_post_type( 'zslider' );
        }

        public static function uninstall(){

            delete_option( 'zslider_options' );

            $posts = get_posts(
                array(
                    'post_type' => 'zslider',
                    'number_posts'  => -1,
                    'post_status'   => 'any'
                )
            );

            foreach( $posts as $post ){
                wp_delete_post( $post->ID, true );
            }
        }

        public function load_textdomain(){
            load_plugin_textdomain(
                'zslider',
                false,
                dirname( plugin_basename( __FILE__ ) ) . '/languages/'
            );
        }

        public function add_menu(){
            add_menu_page(
                esc_html__( 'ZSlider Options', 'zslider' ),
                'ZSlider',
                'manage_options',
                'zslider_admin',
                array( $this, 'zslider_settings_page' ),
                'dashicons-images-alt2'
            );

            add_submenu_page(
                'zslider_admin',
                esc_html__( 'Manage Slides', 'zslider' ),
                esc_html__( 'Manage Slides', 'zslider' ),
                'manage_options',
                'edit.php?post_type=zslider',
                null,
                null
            );

            add_submenu_page(
                'z_slider_admin',
                esc_html__( 'Add New Slide', 'zslider' ),
                esc_html__( 'Add New Slide', 'zslider' ),
                'manage_options',
                'post-new.php?post_type=zslider',
                null,
                null
            );

        }

        public function zslider_settings_page(){
            if( ! current_user_can( 'manage_options' ) ){
                return;
            }

            if( isset( $_GET['settings-updated'] ) ){
                add_settings_error( 'zslider_options', 'zslider_message', esc_html__( 'Settings Saved', 'zslider' ), 'success' );
            }
            
            settings_errors( 'zslider_options' );

            require( ZSLIDER_PATH . 'views/settings-page.php' );
        }

        public function register_scripts(){
            wp_register_script( 'zslider-main-jq', ZSLIDER_URL . 'vendor/flexslider/jquery.flexslider-min.js', array( 'jquery' ), ZSLIDER_VERSION, true );
            wp_register_style( 'zslider-main-css', ZSLIDER_URL . 'vendor/flexslider/flexslider.css', array(), ZSLIDER_VERSION, 'all' );
            wp_register_style( 'zslider-style-css', ZSLIDER_URL . 'assets/css/frontend.css', array(), ZSLIDER_VERSION, 'all' );
        }

        public function register_admin_scripts(){
            global $typenow;
            if( $typenow == 'zslider'){
                wp_enqueue_style( 'zslider-admin', ZSLIDER_URL . 'assets/css/admin.css' );
            }
        }

    }
}

if( class_exists( 'ZSlider' ) ){
    register_activation_hook( __FILE__, array( 'ZSlider', 'activate' ) );
    register_deactivation_hook( __FILE__, array( 'ZSlider', 'deactivate' ) );
    register_uninstall_hook( __FILE__, array( 'ZSlider', 'uninstall' ) );

    $zslider = new ZSlider();
} 

<?php
/**
 * The main plugin class that handles all other plugin parts.
 * 
 * Defines the plugin name, version, and hooks for enqueing the stylesheet and JavaScript.
 * 
 * @package     JKL_Localize_Script_Object_Viewer
 * @subpackage  JKL_Localize_Script_Object_Viewer/inc
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 */

/* Prevent direct access */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'JKL_Localize_Script_Object_Viewer' ) ) {
    
    class JKL_Localize_Script_Object_Viewer {
    
        /**
         * The ID of the plugin.
         * 
         * @since   0.0.1
         * @access  private
         * @var     string  $name       The ID of the plugin.
         */
        private $name;
        
        /**
         * Current version of the plugin.
         * 
         * @since   0.0.1
         * @access  private
         * @var     string  $version    The current version of the plugin.
         */
        private $version;
        
        /**
         * Shortcode
         * 
         * @since   0.0.1
         * @access  private
         * @var     JKL_LSOV_Shortcode    $shortcode  A reference to the shortcode.
         */
        private $shortcode;
        
        
        /**
         * CONSTRUCTOR !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         * Initializes the JKL_Localize_Script_Object_Viewer object and sets its properties
         * 
         * @since   0.0.1
         * @var     string  $name       The name of the plugin.
         * @var     string  $version    The version of the plugin.
         */
        public function __construct( $name, $version ) {
            
            // Set the name and version number
            $this->name     = $name;
            $this->version  = $version;
            
            // Create the shortcode
            $this->make_shortcode();
            
            // Load the plugin and supplementary files
            $this->load();
            
        }
        
        /**
         * Creates the Shortcode
         * 
         * @since   0.0.1
         * @return  object  $shortcode  The Shortcode
         */
        protected function make_shortcode() {
            
            if ( is_null( $this->shortcode ) ) {
                $this->shortcode = new JKL_LSOV_Shortcode();
            }
            return $this->shortcode;
            
        }
        
        /**
         * Loads translation directory
         * Adds the call to enqueue styles and scripts
         * 
         * @since   0.0.1
         */
        protected function load() {
            
            load_plugin_textdomain( 'jkl-localize-script-object-viewer', false, basename( dirname( __FILE__ ) ) . '/languages' );
            add_action( 'wp_enqueue_scripts', array( $this, 'jkl_lsov_scripts_styles' ) );
            
        }
        
        /**
         * Enqueues Styles and Scripts
         * 
         * @since   0.0.1
         */
        public function jkl_lsov_scripts_styles() {
                
                wp_enqueue_style( 'jkl-lsov-style', plugins_url( '../style.css', __FILE__ ) );
            
        }
        
    } // END class JKL_Localize_Script_Object_Viewer
    
} // END if ( ! class_exists() )
<?php
/**
 * The class that create the plugin Shortcode.
 * 
 * Sets up the shortcode and its attributes
 * 
 * @since       0.0.1
 * @package     JKL_Localize_Script_Object_Viewer
 * @subpackage  JKL_Localize_Script_Object_Viewer/inc
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 */

/* Prevent direct access */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'JKL_LSOV_Shortcode' ) ) {
    
    class JKL_LSOV_Shortcode {
        
        /**
         * Builds the shortcode object
         * 
         * @since   0.0.1
         */
        public function __construct() {
            
            $this->register();
            
        }
        
        /**
         * Registers the shortcode with WordPress
         * 
         * @since   0.0.1
         */
        protected function register() {
            
            add_shortcode( 'jkl_lsov', array( $this, 'jkl_unit_converter_make_shortcode' ) );
            
            add_action( 'wp_enqueue_scripts', array( $this, 'jkl_lsov_ajax_scripts' ) );
            add_action( 'wp_ajax_jkl_lsov', array( $this, 'jkl_lsov_ajax' ) );
            add_action( 'wp_ajax_nopriv_jkl_lsov', array( $this, 'jkl_lsov_ajax' ) );
            
        }
        
        public function jkl_lsov_ajax_scripts() {
            wp_enqueue_script( 'jkl-lsov-functions', plugins_url( '../js/ajax.js', __FILE__ ), array( 'jquery' ), '20161019', true );
            wp_localize_script( 'jkl-lsov-functions', 'Postdata', 
                    array(
                        'ajax_url'  => admin_url( 'admin-ajax.php' ),
                        'test'      => array(
                                            'basic'     => array(
                                                'area'                  => __( 'Area', 'jkl-unit-converter' ),
                                                'length_and_distance'   => __( 'Length and Distance', 'jkl-unit-converter' ),
                                                'mass_and_weight'       => __( 'Mass and Weight', 'jkl-unit-converter' ),
                                                'speed'                 => __( 'Speed', 'jkl-unit-converter' ),
                                                'temperature'           => __( 'Temperature', 'jkl-unit-converter' ),
                                                'volume'                => __( 'Volume', 'jkl-unit-converter' ),
                                            ),
                                            'default'   => array(
                                                'angles'                => __( 'Angles', 'jkl-unit-converter' ),
                                                'data_transfer_rate'    => __( 'Data Transfer Rate', 'jkl-unit-converter' ),
                                                'digital_storage'       => __( 'Digital Storage', 'jkl-unit-converter' ),
                                                'energy'                => __( 'Energy', 'jkl-unit-converter' ),
                                                'frequency'             => __( 'Frequency', 'jkl-unit-converter' ),
                                                'fuel_economy'          => __( 'Fuel Economy', 'jkl-unit-converter' ),
                                                'pressure'              => __( 'Pressure', 'jkl-unit-converter' ),
                                                'time'                  => __( 'Time', 'jkl-unit-converter' ),
                                            ),
                                            'advanced'  => array(
                                                'acceleration'          => __( 'Acceleration', 'jkl-unit-converter' ),
                                                'currency'              => __( 'Currency', 'jkl-unit-converter' ),     
                                                'density'               => __( 'Density', 'jkl-unit-converter' ),    
                                                'electric_capacitance'  => __( 'Electric Capacitance', 'jkl-unit-converter' ),
                                                'electric_charge'       => __( 'Electric Charge', 'jkl-unit-converter' ),
                                                'electric_conductance'  => __( 'Electric Conductance', 'jkl-unit-converter' ),
                                                'electric_current'      => __( 'Electric Current', 'jkl-unit-converter' ),    
                                                'flow_rate'             => __( 'Flow Rate', 'jkl-unit-converter' ),
                                                'force'                 => __( 'Force', 'jkl-unit-converter' ),  
                                                'inductance'            => __( 'Inductance', 'jkl-unit-converter' ),  
                                                'light_intensity'       => __( 'Light Intensity', 'jkl-unit-converter' ),
                                                'magnetic_flux'         => __( 'Magnetic Flux', 'jkl-unit-converter' ),    
                                                'misc'                  => _x( 'Misc','miscellaneous', 'jkl-unit-converter' ),
                                                'power'                 => __( 'Power', 'jkl-unit-converter' ),   
                                                'radiation_dosage'      => __( 'Radiation dosage', 'jkl-unit-converter' ),
                                                'radioactivity'         => __( 'Radioactivity', 'jkl-unit-converter' ),   
                                                'torque'                => __( 'Torque', 'jkl-unit-converter' ),
                                                'unitless_numeric'      => __( 'Unitless Numeric', 'jkl-unit-converter' ),
                                                'voltage'               => __( 'Voltage', 'jkl-unit-converter' ),
                                            )
                                    )
                    )
            );
        }
        
        /**
         * Creates the view for the shortcode
         * 
         * Only allows ONE instance of the shortcode per page (include_once)
         * Also prevents it from loading in the sidebar because of include_once
         * 
         * @since   0.0.1
         * @global  post    $post   A reference to the current WordPress Post
         */
        public function jkl_unit_converter_make_shortcode() {
            
            // Prevent loading more than once per Page
            global $post;
            if( has_shortcode( $post->post_content, 'jkl_lsov' ) ) {
                include_once 'view-jkl-lsov-form.php';
            }
            
        }
        
        public function jkl_lsov_ajax() {
            
            if( isset( $_POST[ 'jkl-lsov-input' ] ) ) {
                $data = $_POST[ 'jkl-lsov-input' ];
                //$data = str_replace( '\\', '', $data );
                $result = wp_json_encode( $data );
                echo $result;
                echo '<br>';
                echo $data;
            }
            die();
            
        }
        
    } // END class JKL_LSOV_Shortcode
    
} // END if ( ! class_exists() )

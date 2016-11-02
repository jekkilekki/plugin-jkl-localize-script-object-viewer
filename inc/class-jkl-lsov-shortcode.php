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
            add_action( 'wp_ajax_jkl_lsov_ajax', array( $this, 'jkl_lsov_ajax' ) );
            add_action( 'wp_ajax_nopriv_jkl_lsov_ajax', array( $this, 'jkl_lsov_ajax' ) );
            
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
        
        public function jkl_lsov_ajax_scripts() {
            wp_enqueue_script( 'jkl-lsov-functions', plugins_url( '../js/lsov.ajax.js', __FILE__ ), array( 'jquery' ), '20161019', true );
            wp_localize_script( 'jkl-lsov-functions', 'Postdata', 
                    array(
                        'ajax_url'  => admin_url( 'admin-ajax.php' ),
                        'nonce'     => wp_create_nonce( 'jkl_lsov_nonce' ),
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
         * Hook into wp_ajax_ to localize the PHP contained inside the <textarea>
         * and return the resulting JSON String (prettified) 
         */
        public function jkl_lsov_ajax() {
            
            check_ajax_referer( 'jkl_lsov_nonce', 'nonce' );
            
            $string = str_replace( "\'", '"', $_POST[ 'jkl_lsov_data' ] ); // read in as a string, not array nor object
            //parse_str( $string, $thisArr );
            // echo "Hello world" . 
            // Replace any instances of escaped single quotes \' with double quotes "
            //$string =  $data );
            
            // split the phrase by any number of commas or space characters,
            $array = preg_split('/(=\s?)|(\s+=>\s?)|(\s\s+)/', $string );
            
            // If the first array element is NOT "array("
//            if( $array[0] == "array(" ) {
                $obj = $this->jkl_create_arr( $array );
                $i = 0;
                foreach( $thisArr as $array_obj ) {
                //foreach( $obj as $array_obj ) {
                    echo "[" . $i . "]: " . $array_obj . "<br>";
                    $i++;
                }
//            } else {
//                echo "Not the right one: " . array_shift( $array ) . "<br>";
//            }
            
            
            // echo wp_json_encode( str_replace( "\'", '"', $data ) );
            
//            foreach( ( array ) $data as $key => $value ) {
//                if( !is_scalar( $value ) )
//                    continue;
//                $data[ $key ] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8' );
//            }
//            $script = "var $object_name = " . wp_json_encode( $data ) . ';';
            $script = wp_json_encode( array( 'list1' => array( 'item1' => 'value1' ), 'list2' => array( 'item1' => 'value1', 'item2' => 'value2' ) ) ) . ';';
            //$script = wp_json_encode( $data );
//            $pos = array_search( 'array', $data );
//            $data = substr( $data, $pos );
            //echo $script;
            
            // Always die in functions echoing Ajax content
            die();
            
        }
        
        /**
         * Check out this @link http://jsteemann.github.io/blog/2015/06/16/parsing-php-arrays-with-php/
         */
        public function jkl_create_arr( $array, $depth = 0 ) {
            
            // Find the start of our array
            $index = array_search( 'array(', $array ); // find first index of 'array(' and set that to the index
            $newArr = [];
            
            // If anything preceeds 'array(', get rid of it
            for( $i = 0; $i < $index; $i++ ) {
                array_shift( $array );
            }
            
            // Loop over the rest of the array to properly reconstruct the original input array
            for( $i = 0; $i < $array.length; $i++ ) {
                //$newArr[] = $obj;
                $tempStr = "";
                $tempArr = [];
                
                // If there's an 'array(', start a new Array variable and populate it 
                // Recursively call this same function
                if( 'array(' == $array[ $i ] ) {
//                    $tempArr = array_reverse( $array );
//                    $arrEnd = array_search( '),', $tempArr );
//                    $newArr[] = $this->jkl_create_arr( array_slice( $array, $array[i], $array.length-$arrEnd ), $depth++ );
//                }
//                // If there's a value with double quotes " we know it's the key value
//                elseif( strpos( $array[ $i ], '"' ) != -1 ) {
//                    if( 'array(' == $array[ $i+1 ] ) {
//                        $tempArr = array_reverse( $array );
//                        $arrEnd = array_search( '),', $tempArr );
//                        $tempArr = $this->jkl_create_arr( array_slice( $array, $array[i], $array.length-$arrEnd ), $depth++ );
//                    } else {
//                        $newArr[ "{$array[$i]}" ] = $array[ $i+1 ];
//                    }
//                }
//                // If we find the end of an array, just skip over it (should be properly cared for in the jkl_create_sub_arr() method
//                elseif( '),' == $array[ $i ] && $depth != 0 ) {
//                    return $newArr;
//                }
//                // All other values must be the values for our keys
//                else {
//                    $newArr[] = "Hmm, default value.";
                }
            }
            
            // Error checking
            $newArr[] = $index;
            $newArr[] = $array[ $index ];
            return $array;
        }
        
    } // END class JKL_LSOV_Shortcode
    
} // END if ( ! class_exists() )

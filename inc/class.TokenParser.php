<?php
/**
 * Parser for simple PHP arrays
 * 
 * @package     JKL_Localize_Script_Object_Viewer
 * @subpackage  JKL_Localize_Script_Object_Viewer/inc
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 */

/* Prevent direct access */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'JKL_TokenParser' ) ) {
    
    class JKL_TokenParser {
        
        private static $CONSTANTS = array(
            'null'  => null,
            'true'  => true,
            'false' => false
        );
        
        private $tokens;
        
        public function __construct( Tokens $tokens ) {
            $this->tokens = $tokens;
        }
        
        public function parseValue() {
            // strings
            if( $this->tokens->doesMatch( T_CONSTANT_ENCAPSED_STRING ) ) {
                $token = $this->tokens->pop();
                return stripslashes( substr( $token[1], 1, -1 ) );
            }
            
            // built-in string literals: null, false, true
            if( $this->tokens->doesMatch( T_STRING ) ) {
                $token = $this->tokens->pop();
                $value = strtolower( $token[1] );
                if( array_key_exists( $value, self::$CONSTANTS ) ) {
                    return self::$CONSTANTS[ $value ];
                }
                throw new Exception( "Unexpected string literal ". $token[1] );
            }
            
            // the rest...
            // we expect a number here
            $uminus = 1;
            
            // unary minus
            if( $this->tokens->doesMatch( "-" ) ) {
                $this->tokens->forceMatch( "-" );
                $uminus = -1;
            }
            
            // long number
            if( $this->tokens->doesMatch( T_LNUMBER ) ) {
                $value = $this->tokens->pop();
                return $uminus * (int) $value[1];
            }
            
            // double number
            if( $this->tokens->doesMatch( T_DNUMBER ) ) {
                $value = $this->tokens->pop();
                return $uminus * (double) $value[1];
            }
            
            throw new Exception( "Unexpected value token" );
            
        }
        
        public function parseArray() {
            $found = 0;
            $result = array();
            
            $this->tokens->forceMatch( T_ARRAY );
            $this->tokens->forceMatch( "(" );
            
            while( true ) {
                // find the end of the array
                if( $this->tokens->doesMatch( ")" ) ) {
                    $this->tokens->forceMatch( ")" );
                    break;
                }
                
                // there must be a comma after the first element
                if( $found > 0 ) {
                    $this->tokens->forceMatch( "," );
                }
                
                // Check for a nested array first
                if( $this->tokens->doesMatch( T_ARRAY ) ) {
                    $result[] = $this->parseArray();
                }
                // Then, check for a string
                elseif( $this->tokens->doesMatch( T_CONSTANT_ENCAPSED_STRING ) ) {
                    $string = $this->parseValue();
                    // Is this a (key => value) pair?
                    if( $this->tokens->doesMatch( T_DOUBLE_ARROW ) ) {
                        $this->tokens->pop();
                        $result[ $string ] = $this->parseValue();
                    }
                    // Not (key => value), then just a simple string value
                    else {
                        $result[] = $string;
                    }
                }
                // Everything else, just append
                else {
                    $result[] = $this->parseValue();
                }
                
                ++$found;
            }
            
            return $result;
        }
        
    } // END class JKL_TokenParser
    
} // END ! class_exists( 'JKL_TokenParser' )


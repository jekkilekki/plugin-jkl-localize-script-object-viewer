<?php
/**
 * Class to manage tokens (read in and parsed from input)
 * 
 * @package     JKL_Localize_Script_Object_Viewer
 * @subpackage  JKL_Localize_Script_Object_Viewer/inc
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 */

/* Prevent direct access */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'JKL_Tokens' ) ) {

    /**
     * @see http://php.net/manual/en/function.token-get-all.php
     * @see http://php.net/manual/en/tokens.php
     * @see http://php.net/manual/en/function.token-name.php
     */
    class JKL_Tokens {
        
        private $tokens;
        
        public function __construct( $code ) {
            // construct PHP code from string and tokenize it
            // append <?php to our input string to make PHP read it as code
            $tokens = token_get_all( "<?php " . $code );
            // remove all whitespace tokens
            $this->tokens = array_filter( $tokens, function( $token ) {
                return ( !is_array( $token ) || $token[0] !== T_WHITESPACE );
            });
            // remove start token (<?php>
            $this->pop();
        }
        
        public function getTokenArr() {
            return $this->tokens;
        }
        
        /**
         * Checks to see if the Tokens array is "done" (empty) or not
         * 
         * @return  boolean    true if there are no more tokens in the array
         */
        public function done() {
            return count( $this->tokens ) === 0;
        }
        
        /**
         * Removes the first token from the Tokens array
         * @return  token   The first token from the front of the Tokens array
         * @throws  Exception
         */
        public function pop() {
            // consume the token and return it
            if( $this->done() ) {
                throw new Exception( "Already at the end of tokens!" );
            }
            return array_shift( $this->tokens );
        }
        
        /**
         * Takes a look at (returns) the first token from the Tokens array
         * @return  token   The first token from the front of the Tokens array
         * @throws  Exception
         */
        public function peek() {
            // return next token, don't consume it
            if( $this->done() ) {
                throw new Exception( "Already at the end of tokens!" );
            }
            return $this->tokens[0];
        }
        
        /**
         * 
         * @param   type $what
         * @return  boolean
         */
        public function doesMatch( $what ) {
            // Look at the first token
            $token = $this->peek();
            
            if( is_string( $what ) && !is_array( $token ) && $token === $what ) {
                return true;
            }
            if( is_int( $what ) && is_array( $token ) && $token[0] === $what ) {
                return true;
            }
            return false;
        }
        
        /**
         * 
         * @param   type $what
         * @throws  Exception
         */
        public function forceMatch( $what ) {
            if( ! $this->doesMatch( $what ) ) {
                if( is_int( $what ) ) {
                    throw new Exception( "Unexpected token - expecting " . token_name( $what ) );
                }
                throw new Exception( "Unexpected token - expecting " . $what );
            }
            // Remove the token
            $this->pop();
        }
        
    } // END class JKL_Tokens
    
} // END if ( ! class_exists() )
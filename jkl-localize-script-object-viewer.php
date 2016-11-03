<?php
/**
 * @since       1.0.0
 * @package     JKL_Localize_Script_Object_Viewer
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 * 
 * @wordpress-plugin
 * Plugin Name: JKL Localize Script Object Viewer
 * Plugin URI:  https://github.com/jekkilekki/plugin-jkl-localize-script-object-viewer
 * Description: A simple plugin that allows you to easily view the JavaScript object/array that wp_localize_script() would produce from a PHP array.
 * Version:     1.0.0
 * Author:      Aaron Snowberger
 * Author URI:  http://www.aaronsnowberger.com
 * Text Domain: jkl-localize-script-object-viewer
 * Domain Path: /languages/
 * License:     GPL2
 * 
 * Requires at least: 3.5
 * Tested up to: 4.6
 */

/**
 * JKL Localize Script Object Viewer allows you to easily view the JavaScript object
 * or array that would be produced from passing in a PHP array.
 * Copyright (C) 2016  AARON SNOWBERGER (email: JEKKILEKKI@GMAIL.COM)
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

/* Prevent direct access */
if ( ! defined( 'WPINC' ) ) die;

require_once plugin_dir_path( __FILE__ ) . 'inc/class.jkl-lsov.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/class.jkl-lsov-shortcode.php';

require_once plugin_dir_path( __FILE__ ) . 'inc/class.Tokens.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/class.TokenParser.php';

function run_lsov() {
    // Instantiate the plugin class
    $JKL_LSOV = new JKL_Localize_Script_Object_Viewer( 'jkl-lsov', '1.0.0' );
}

run_lsov();
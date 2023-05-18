<?php
/**
 * @package plugin-boilerplate
 */
/**
 * Plugin Name: Plugin Boilerplate
 * Plugin URI: https://seloku.com/freeplugins/pluginboilerplate
 * Description: This is a simple plugin development boilerplate.
 * Version: 1.0.0
 * Author: Joseph M
 * Author URI: https://seloku.com/about
 * License: GPLv2 or later
 * Text Domain: pluginboilerplate
 * 
 */
/**GNU GPL+ license */
 /*
    This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License
    as published by the Free Software Foundation; either version 2
    of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
  */

/**
 * Restrict direct access in 3 methods
 */
if ( ! defined ('ABSPATH') ) {
    die; //exit;
}

/*
defined( 'ABSPATH' ) or die( 'You don\t have acccess to this file!');

if ( ! function_exists( 'add_action') ) {
    echo 'You don\t have acccess to this file!';
    die;
}
*/

/*define a class BoilerPlatePlugin */
class BoilerPlatePlugin
{
    // register scripts using standard method inside a class
    function register() {
        add_action('admin_enqueue_scripts', array( $this, 'enqueue' ) );
    }
    // enqueue all our scripts using standard method
    function enqueue() {
        //styles(bppstyle= handler(id))
        wp_enqueue_style('bppstyle', plugins_url( './assets/bpp.css', __FILE__) );
        wp_enqueue_style('bpp-main', plugins_url('./assets/bpp-main.css', __FILE__) );
        //scripts
        wp_enqueue_script('bppscript', plugins_url('./assets/bpp.js', __FILE__) );
    }

    // refactored to use protected method
    function __construct() {
        //hook custom_post_type() inside the class with construct()
        add_action('init', array( $this, 'custom_post_type' ) );
    }
     
    // protected function create_post_type() {
    //     add_action('init', array( $this, 'custom_post_type' ) );
    // }
    /* Register custom post-type inside the class, its done differenly in procedural OOP
    (hook add action inside class via "__construct method" with "$this" keyword above ),
    unlike structural programming where we hook action outside the function
    */
    function custom_post_type() {
        register_post_type('book', ['public' => true, 'label' => 'Books'] );
    }


    function activate() {
        /** Here you can: genetare CPT, flush rewrite rules */
        $this->custom_post_type();
        flush_rewrite_rules();
    }
    function deactivate() {
        /** Here you can: flush rewrite rules*/
        flush_rewrite_rules();
    }
     /**________Preferably use separate uninstall file to avoid errors  */   

}


/*conditionally initialize the class with a variable for reusability */ 
if ( class_exists( 'BoilerPlatePlugin') ) {
    $bpp = new BoilerPlatePlugin();
    //trigger scripts 'register' method
    $bpp-> register();
}
 
// register plugin (de)activation hooks
register_activation_hook(__FILE__, array($bpp, 'activate' ) );
register_deactivation_hook(__FILE__, array($bpp, 'deactivate'));


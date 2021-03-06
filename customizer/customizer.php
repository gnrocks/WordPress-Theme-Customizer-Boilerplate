<?php

/**
 * Theme Customizer Boilerplate
 *
 * @package		Theme_Customizer_Boilerplate
 * @copyright	Copyright (c) 2012, Slobodan Manic
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 * @author		Slobodan Manic
 *
 * @since		Theme_Customizer_Boilerplate 1.0

	License:
	
	Copyright 2013 Slobodan Manic (slobodan.manic@gmail.com)
	
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/


/**
 * Arrays of options
 */	
require( get_stylesheet_directory() . '/customizer/options.php' );

/**
 * Helper functions
 */	
require( get_stylesheet_directory() . '/customizer/helpers.php' );


/**
 * Adds Customizer Sections, Settings and Controls
 *
 * - Require Custom Customizer Controls
 * - Add Customizer Sections
 *   -- Add Customizer Settings
 *   -- Add Customizer Controls
 *
 * @uses	thsp_get_theme_customizer_sections()	Defined in helpers.php
 * @uses	thsp_settings_page_capability()			Defined in helpers.php
 * @uses	thsp_get_theme_customizer_fields()		Defined in get-options.php
 *
 * @link	$wp_customize->add_section				http://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_section
 * @link	$wp_customize->add_setting				http://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
 * @link	$wp_customize->add_control				http://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
 */
function thsp_customize_register( $wp_customize ) {

	/**
	 * Create custom controls
	 */	
	require( get_stylesheet_directory() . '/customizer/extend.php' );

	/*
	 * Get all the fields using a helper function
	 */
	$thsp_sections = thsp_get_theme_customizer_fields();

	/**
	 * Loop through the array and add Customizer sections
	 */
	foreach( $thsp_sections as $thsp_section_key => $thsp_section_value ) {
		
		/**
		 * Adds Customizer section, if needed
		 */
		if( ! $thsp_section_value['existing_section'] ) {
			
			$thsp_section_args = $thsp_section_value['args'];
			
			// Add section
			$wp_customize->add_section(
				$thsp_section_key,
				$thsp_section_args
			);
			
		} // end if
		
		/*
		 * Loop through 'fields' array in each section
		 * and add settings and controls
		 */
		$thsp_section_fields = $thsp_section_value['fields'];
		foreach( $thsp_section_fields as $thsp_field_key => $thsp_field_value ) {

			/**
			 * Adds Customizer settings
			 */
			$wp_customize->add_setting(
				"my_theme_options[$thsp_field_key]",
				$thsp_field_value['setting_args']
			);

			/**
			 * Adds Customizer control
			 *
			 * 'section' value must be added to 'control_args' array
			 * so control can get added to current section
			 */
			$thsp_field_value['control_args']['section'] = $thsp_section_key;
			$wp_customize->add_control(
				"my_theme_options[$thsp_field_key]",
				$thsp_field_value['control_args']
			);
				
		} // end foreach
		
	}

}
add_action( 'customize_register', 'thsp_customize_register' );
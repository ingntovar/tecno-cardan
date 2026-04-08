<?php

if ( function_exists( 'acf_add_local_field_group' ) ) {

	/**
	 * Set Up JSON Syncing
	 */

	add_filter( 'acf/settings/save_json', 'tc_acf_json_save_point' );

	function tc_acf_json_save_point( $path ) {

		// update path
		$path = get_stylesheet_directory() . '/includes/acf/json-sync';

		// return
		return $path;
	}

	add_filter( 'acf/settings/load_json', 'tc_acf_json_load_point' );

	function tc_acf_json_load_point( $paths ) {

		// remove original path (optional)
		unset( $paths[0] );

		// append path
		$paths[] = get_stylesheet_directory() . '/includes/acf/json-sync';

		// return
		return $paths;
	}
}

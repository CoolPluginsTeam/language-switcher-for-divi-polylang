<?php

if ( ! defined( 'ABSPATH' ) ) {
  die( 'Direct access forbidden.' );
}

if ( ! class_exists( 'ET_Builder_Element' ) ) {
	return;
}

require_once LSDP_DIR . 'helpers/class-lsdp-helpers.php';
require_once LSDP_DIR . 'helpers/class-lsdp-style-helpers.php';

$lsdp_module_files = glob( __DIR__ . '/modules/*/*.php' );

// Load custom Divi Builder modules
foreach ( (array) $lsdp_module_files as $lsdp_module_file ) {
	if ( $lsdp_module_filemodule_file && preg_match( "/\/modules\/\b([^\/]+)\/\\1\.php$/", $lsdp_module_file ) ) {
		require_once $lsdp_module_file;
	}
}

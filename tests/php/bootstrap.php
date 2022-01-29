<?php
/**
 * Unit tests bootstrap.
 */

namespace WP_Theme_Unit_Tests\Tests;

/**
 * Setup the unit test environment
 *
 * @return void
 * @throws Exception Errors when WP_DEVELOP_DIR not set.
 */
function bootstrap() {

	// Run this in your shell to point to whever you cloned WP.
	// git clone git@github.com:WordPress/wordpress-develop.git
	// Example: export WP_DEVELOP_DIR="/Users/petenelson/projects/wordpress/wordpress-develop/".
	$wp_develop_dir = getenv( 'WP_DEVELOP_DIR' );

	if ( empty( $wp_develop_dir ) ) {
		throw new \Exception(
			'ERROR' . PHP_EOL . PHP_EOL .
			'You must define the WP_DEVELOP_DIR environment variable.' . PHP_EOL
		);
	}

	if ( ! file_exists( $wp_develop_dir ) ) {
		throw new \Exception(
			'ERROR' . PHP_EOL . PHP_EOL .
			$wp_develop_dir . ' does not exist.' . PHP_EOL
		);
	}

	define( 'IPM_DOING_UNIT_TESTS', true );

	// Load the composer stuff installed by WordPress.
	require_once $wp_develop_dir . '/vendor/autoload.php';

	// Give access to tests_add_filter() function.
	require_once $wp_develop_dir . '/tests/phpunit/includes/functions.php';

	tests_add_filter( 'muplugins_loaded', __NAMESPACE__ . '\manually_load' );
	tests_add_filter( 'theme_root', __NAMESPACE__ . '\get_current_theme_root' );
	tests_add_filter( 'template_directory', __NAMESPACE__ . '\get_current_theme_root' );

	// Start up the WP testing environment.
	require $wp_develop_dir . '/tests/phpunit/includes/bootstrap.php';
	require_once dirname( __FILE__ ) . '/phpunit/Base_Test.php';

	// Switch to your custom theme root.
	switch_theme( get_current_theme_root() );
}

/**
 * Manually load any necessary plugins.
 */
function manually_load() {
	$includes = []; // Manually load other plugin files here.

	foreach ( $includes as $file ) {

		if ( ! file_exists( $file ) ) {
			throw new \Exception(
				'ERROR' . PHP_EOL . PHP_EOL .
				$file . ' does not exist.' . PHP_EOL
			);

			exit;
		}

		require_once $file;
	}
}

/**
 * Gets the theme root.
 *
 * @return string
 */
function get_current_theme_root() {
	$root = dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) );

	$root = $root . '/themes/custom-theme'; // Put your custom theme name here.

	return $root;
}

// Start up the unit tests env.
bootstrap();

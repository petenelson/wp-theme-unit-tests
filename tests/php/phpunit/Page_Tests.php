<?php
/**
 * Page Tests
 *
 * @package WP_Theme_Unit_Tests
 */

namespace WP_Theme_Unit_Tests\Tests;

/**
 * Page Tests
 */
class Page_Tests extends Base_Test {

	/**
	 * Basic Page Test
	 *
	 * @return void
	 */
	public function test_page() {

		$post_id = $this->create_post( 'page', 'My Sample Page' );

		$this->go_to( '/my-sample-page/' );

		$this->assertSame( $post_id, get_the_ID() );

		$this->assertSame( 'My Sample Page', get_the_title() );

		add_filter( 'wp_using_themes', '__return_true' );

		$template_loader = ABSPATH . WPINC . '/template-loader.php';

		ob_start();
		require_once $template_loader;

		$output = ob_get_clean();

		$this->assertContains( 'Hello World', $output );

	}
}

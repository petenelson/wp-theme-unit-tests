<?php
/**
 * Sample Tests
 *
 * @package WP_Theme_Unit_Tests
 */

namespace WP_Theme_Unit_Tests\Tests;

/**
 * Sample Test
 */
class Sample_Tests extends Base_Test {

	/**
	 * Basic test to verify unit tests are running.
	 *
	 * @return void
	 */
	public function test_hello_world() {

		$this->assertTrue( true );

		$hello_world = \MyCustomTheme\get_hello_world();

		$this->assertSame( 'Hello World', $hello_world );
	}
}

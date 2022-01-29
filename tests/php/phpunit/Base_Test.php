<?php
/**
 * Base Unit Test
 *
 * @package WP_Theme_Unit_Tests
 */

namespace WP_Theme_Unit_Tests\Tests;

/**
 * Base Unit Test
 */
class Base_Test extends \WP_UnitTestCase {

	/**
	 * Setup any pre-test data.
	 *
	 * @param  WP_UnitTest_Factory $factory The unit test factory.
	 * @return void
	 */
	public static function wpSetUpBeforeClass( \WP_UnitTest_Factory $factory ) {
		$factory->user->create(
			[
				'user_login'   => 'theme_administrator',
				'display_name' => 'theme_administrator',
				'role'         => 'administrator',
				'first_name'   => 'theme',
				'last_name'    => 'admin',
			]
		);
	}

	/**
	 * Set current user to an admin.
	 *
	 * @return int The admin user ID.
	 */
	public function set_admin_user() {

		$user = get_user_by( 'login', 'theme_administrator' );
		$this->assertInstanceOf( '\WP_User', $user );

		wp_set_current_user( $user->ID );

		return $user->ID;
	}

	/**
	 * Creates a post.
	 *
	 * @param  string $post_type  The post type.
	 * @param  string $post_title The post title.
	 * @param  array  $postarr    Any additional postarr values.
	 * @return int
	 */
	public function create_post( $post_type, $post_title, $postarr = [] ) {

		$postarr = wp_parse_args(
			$postarr,
			[
				'post_type'   => $post_type,
				'post_title'  => $post_title,
				'post_status' => 'publish',
			]
		);

		$post_id = wp_insert_post( $postarr );

		$this->assertNotEmpty( $post_id );
		$this->assertSame( $post_type, get_post_type( $post_id ) );

		return $post_id;
	}

	/**
	 * Deletes all testing data.
	 *
	 * @return void
	 */
	public function delete_all_test_data() {
		$query_args = [
			'post_type'      => 'any',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		];

		$query = new \WP_Query( $query_args );

		foreach ( $query->posts as $post_id ) {
			wp_delete_post( $post_id, true );
		}

		// TODO delete all terms.
	}
}

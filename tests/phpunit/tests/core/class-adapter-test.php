<?php
/**
 * Unit tests covering Adapter functionality.
 *
 * @package Remove_Noreferrer
 * @subpackage Core
 * @since 2.0.0
 */

namespace Remove_Noreferrer\Core;

/**
 * Test core/class-adapter.php
 *
 * @coversDefaultClass Remove_Noreferrer\Core\Adapter
 * @group core
 */
class Adapter_Test extends \WP_UnitTestCase {
	/**
	 * Adapter instance
	 *
	 * @since 2.0.0
	 * @access private
	 * @var Adapter $adapter
	 */
	private $adapter;

	/**
	 * Prepares environment
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->adapter = new Adapter();
	}

	/**
	 * Finishes tests
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();

		unset( $GLOBALS['screen'] );
		unset( $GLOBALS['current_screen'] );
	}

	/**
	 * @covers ::is_admin
	 * @covers ::is_single
	 * @covers ::is_page
	 * @covers ::is_posts_page
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function test_is_admin(): void {
		set_current_screen( 'dashboard' );

		$this->assertTrue( $this->adapter->is_admin() );
		$this->assertFalse( $this->adapter->is_single() );
		$this->assertFalse( $this->adapter->is_page() );
		$this->assertFalse( $this->adapter->is_posts_page() );
	}

	/**
	 * @covers ::is_admin
	 * @covers ::is_single
	 * @covers ::is_page
	 * @covers ::is_posts_page
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function test_is_single(): void {
		$post = $this->factory->post->create();

		$this->go_to( '?p=' . $post );

		$this->assertTrue( $this->adapter->is_single() );
		$this->assertFalse( $this->adapter->is_admin() );
		$this->assertFalse( $this->adapter->is_page() );
		$this->assertFalse( $this->adapter->is_posts_page() );
	}

	/**
	 * @covers ::is_admin
	 * @covers ::is_single
	 * @covers ::is_page
	 * @covers ::is_posts_page
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function test_is_page(): void {
		$page = $this->factory->post->create( array( 'post_type' => 'page' ) );

		$this->go_to( '?page_id=' . $page );

		$this->assertTrue( $this->adapter->is_page() );
		$this->assertFalse( $this->adapter->is_admin() );
		$this->assertFalse( $this->adapter->is_single() );
		$this->assertFalse( $this->adapter->is_posts_page() );
	}

	/**
	 * @covers ::is_admin
	 * @covers ::is_single
	 * @covers ::is_page
	 * @covers ::is_posts_page
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function test_is_posts_page(): void {
		$this->go_to( '/' );

		$this->assertTrue( $this->adapter->is_posts_page() );
		$this->assertFalse( $this->adapter->is_admin() );
		$this->assertFalse( $this->adapter->is_single() );
		$this->assertFalse( $this->adapter->is_page() );
	}
}

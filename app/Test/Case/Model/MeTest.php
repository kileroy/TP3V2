<?php
App::uses('Me', 'Model');

/**
 * Me Test Case
 *
 */
class MeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.me',
		'app.adult',
		'app.my_event',
		'app.senior_citizen',
		'app.teenager'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Me = ClassRegistry::init('Me');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Me);

		parent::tearDown();
	}

}
